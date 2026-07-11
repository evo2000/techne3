float oldX = 0;
float oldY = 0;

void setup(){
  size(600, 160);
}

void draw(){
  background(211);
  
  for(float x = 0; x <= width; x++){
   float y = 40*sin(0.02*(x+160))+80;
   stroke(255, 0, 0);
   if(dist(x, 0, mouseX, 0) < 80){
     stroke(255);
   }
   if(x != 0){
     line(oldX, oldY, x, y);
   }
   oldX = x;
   oldY = y;
  }
  for(float x = 0; x <= width; x++){
   float y = 60*sin(0.02*(x+200))+80;
   stroke(255, 0, 0);
   if(dist(x, 0, mouseX, 0) < 80){
     stroke(255);
   }
   if(x != 0){
     line(oldX, oldY, x, y);
   }
   oldX = x;
   oldY = y;
  }
}
