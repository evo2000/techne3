int spacer;

void setup(){
  size(601, 161);
  spacer = 10; //dist between grid pts
}

void draw(){
  background(0);
  stroke(255);
  for(int x = 0; x <= width; x += spacer){
    for(int y = 0; y <= height; y += spacer){
      point(x, y);
      float distance = min(100, dist(x, y, mouseX, mouseY));
      float mag = map(distance, 0, 100, spacer/2, 0);
      line(x - mag, y, x + mag, y);
      line(x, y - mag, x, y + mag);
    }
  }
}