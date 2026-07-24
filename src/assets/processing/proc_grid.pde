/* @pjs preload="/assets/processing/cloud.jpg"; */
PImage img;

int canvasW = 600;
int canvasH = 160;

// ---- GRID + INTERACTION ----
float baseSpacing = 10;
float influenceRadius = 80;
float maxPush = 20;

float smallDot = 3;
float bigDot = 7;

int cols, rows;
boolean[][] bigPoint;

// ---- VIRTUAL CURSOR ----
float cursorX = 540; // starting X position
float cursorY = 60;  // starting Y position
boolean mouseActive = false;
float cursorEase = 0.15; // lerp speed

// ---- GLYPHS (5x7 each) ----
// 1 = big point, 0 = small point
int[][] glyph_t = {
  {0,0,1,0,0},
  {0,0,1,0,0},
  {0,1,1,1,1},
  {0,0,1,0,0},
  {0,0,1,0,0},
  {0,0,1,0,0},
  {0,0,0,1,1}
};

int[][] glyph_e = {
  {0,0,0,0,0},
  {0,0,0,0,0},
  {0,1,1,1,0},
  {1,0,0,0,1},
  {1,1,1,1,1},
  {1,0,0,0,0},
  {0,1,1,1,0}
};

int[][] glyph_c = {
  {0,0,0,0,0},
  {0,0,0,0,0},
  {0,1,1,1,0},
  {1,0,0,0,1},
  {1,0,0,0,0},
  {1,0,0,0,0},
  {0,1,1,1,0}
};

int[][] glyph_h = {
  {1,0,0,0,0},
  {1,0,0,0,0},
  {1,1,1,1,0},
  {1,0,0,0,1},
  {1,0,0,0,1},
  {1,0,0,0,1},
  {1,0,0,0,1}
};

int[][] glyph_n = {
  {0,0,0,0,0},
  {0,0,0,0,0},
  {1,1,1,1,0},
  {1,0,0,0,1},
  {1,0,0,0,1},
  {1,0,0,0,1},
  {1,0,0,0,1}
};

int[][] glyph_dot = {
  {0,0,0,0,0},
  {0,0,0,0,0},
  {0,0,0,0,0},
  {0,0,0,0,0},
  {0,0,0,0,0},
  {0,0,0,0,0},
  {1,1,0,0,0}
};

// Order spells: "techne."
int[][][] text = {
  glyph_t,
  glyph_e,
  glyph_c,
  glyph_h,
  glyph_n,
  glyph_e,
  glyph_dot
};

int glyphSpacing = 1; // one column between characters
int offsetX = 2;
int offsetY = 8;

void setup() {
  size(600, 160);
  smooth();
  img = loadImage("/assets/processing/cloud.jpg");

  cols = int(width / baseSpacing) + 1;
  rows = int(height / baseSpacing) + 1;

  bigPoint = new boolean[cols][rows];

  // ---- COMPOSE TEXT INTO GRID ----
  int cursorGridX = offsetX;

  for (int g = 0; g < text.length; g++) {
    int[][] glyph = text[g];

    for (int y = 0; y < glyph.length; y++) {
      for (int x = 0; x < glyph[y].length; x++) {
        if (glyph[y][x] == 1) {
          int gx = cursorGridX + x;
          int gy = offsetY + y;

          if (gx >= 0 && gx < cols && gy >= 0 && gy < rows) {
            bigPoint[gx][gy] = true;
          }
        }
      }
    }

    cursorGridX += glyph[0].length + glyphSpacing;
  }
}

void draw() {
  // ---- UPDATE CURSOR POSITION ----
  // Activate mouse tracking on first movement
  if (!mouseActive && (mouseX != pmouseX || mouseY != pmouseY)) {
    mouseActive = true;
  }

  // Smoothly interpolate toward the real mouse
  if (mouseActive) {
    cursorX = lerp(cursorX, mouseX, cursorEase);
    cursorY = lerp(cursorY, mouseY, cursorEase);
  }

  // ---- DRAW BACKGROUND ----
  background(img);

  noStroke();
  fill(255, 255, 255, 180);

  // ---- DRAW DOT GRID ----
  for (int gx = 0; gx < cols; gx++) {
    for (int gy = 0; gy < rows; gy++) {

      float x = gx * baseSpacing;
      float y = gy * baseSpacing;

      float dx = x - cursorX;
      float dy = y - cursorY;
      float d = sqrt(dx*dx + dy*dy);

      float px = x;
      float py = y;

      if (d < influenceRadius && d > 0) {
        float strength = (influenceRadius - d) / influenceRadius;
        float push = strength * maxPush;
        px += (dx / d) * push;
        py += (dy / d) * push;
      }

      float dotSize = bigPoint[gx][gy] ? bigDot : smallDot;
      ellipse(px, py, dotSize, dotSize);
    }
  }
}
