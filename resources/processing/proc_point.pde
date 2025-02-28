float[][] pts = new float[10][2]; //array of random (x, y) coordinates
float[] mag = new float[10]; //array of distances from each random point to cursor
float minmag; //minimum distance in mag[]

void setup(){
  size(600, 160);
  textSize(32);
  for(int i = 0; i < 10; i++){
    pts[i][0] = random(width); //fill pts[] with random x values
  }
  for(int i = 0; i < 10; i++){
    pts[i][1] = random(height); //fill pts[] with random y values
  }

  draw_point(400, 100);
}

void draw(){
  if(mouseX != 0 || mouseY != 0) {
    draw_point(mouseX, mouseY);
  }
}

void draw_point(int x_in, int y_in) {
  background(211);

  for(int i = 0; i < 10; i++){
    stroke(0);
    point(pts[i][0], pts[i][1]); //draw random points generated in pts[] in setup()
    stroke(0, 0);
    fill(255, 64);
    ellipse(pts[i][0], pts[i][1], 50, 50);
    mag[i] = dist(pts[i][0], pts[i][1], x_in, y_in); //fill mag[] with distances from mouse to each point
  }
  
  minmag = min(mag); //minmag = least distance in mag[]
  for(int i = 0; i < 10; i++){
    if(mag[i] == minmag){
      stroke(255, 0, 0);
      line(pts[i][0], pts[i][1], x_in, y_in);
      mag[i] = 2000; // set mag to higher than possible value, to nullify
    }
  }
  
  minmag = min(mag); //minmag = least distance in mag[]
  for(int i = 0; i < 10; i++){
    if(mag[i] == minmag){
      stroke(255, 0, 0);
      line(pts[i][0], pts[i][1], x_in, y_in);
      mag[i] = 2000; // set mag to higher than possible value, to nullify
    }
  }
  
  minmag = min(mag); //minmag = least distance in mag[]
  for(int i = 0; i < 10; i++){
    if(mag[i] == minmag){
      stroke(255, 0, 0);
      line(pts[i][0], pts[i][1], x_in, y_in);
      mag[i] = 2000; // set mag to higher than possible value, to nullify
    }
  }
}