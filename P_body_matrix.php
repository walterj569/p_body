////Matrix class
class Matrix {

  ///instance variables
  public $rows;
  public $cols;
  public $matrix;


  ///constructor
  public function __construct($rows, $cols){
     $this->rows = $rows;
     $this->cols = $cols;
     $this->matrix = array();


     for($i=0; $i< $this->rows; $i++) {
       $this->matrix[$i] = array();
       for($j=0; $j<$this->cols; $j++) {
           $this->matrix[$i][$j] = 0;
       }
     }
  }


  ///static methods

  //static multiply method
  public static function staticMultiply($m1, $m2){
    if($m1 instanceof Matrix && $m2 instanceof Matrix){

      throw new Exception("Invalid input, both inputs must be instances of a Matrix");

    }else{
      if($m1->cols == $m2->rows){//
        $result = new Matrix($m1->rows, $m2->cols);
        for($i =0 ; $i < $result->rows; $i++){//
          for($j =0 ; $j < $result->cols; $j++){//
             $sum = 0;
             for($k = 0; $k < $m1->cols; $k++){//
               $sum = $sum + $m1->matrix[$i][$k] * $m2->matrix[$k][$j];
             }//
             $result->matrix[$i][$j] = $sum;
            }//
          }//
        return $result;
      }else{
        throw new Exception("Matrix no1 number columns must equal Matrix no2 number of rows");
      }
    }
  }


  //static subrtact method

  public static function staticSubtract($a, $b){
    if($a instanceof Matrix && $b instanceof Matrix){

      throw new Exception("Invalid input, both inputs must be instances of a Matrix");

    }else{

     $result = new Matrix($a->rows, $a->cols);
     for($i = 0; $i < $result->rows; $i++){
        for( $j =0; $j < $result->cols; $j++){
          $result->matrix[$i][$j] = $a->matrix[$i][$j] - $b->matrix[$i][$j];
        }
      }
      return $result;
    }
  }

  //static method that converts a matrix into an array

  public static function fromArray($arr){
    $m = new Matrix(sizeof($arr), 1);
    for ($i = 0; $i < sizeof($arr); $i++){
      $m->matrix[$i][0] = $arr[$i];
    }
    return $m;
  }


   //static method that converts a matrix to an array

   public static function toArray($m){
     $arr = array();
     for($i = 0; $i < $m->rows; $i++){
        for($j =0; $j < $m->cols; $j++){
          array_push($arr, $m->matrix[$i][$j]);
        }
     }
     return $arr;
   }


   //static function that Maps the Matrix (THis part is currently incomplete and needs more work)

   public static function staticMap($matrix, $func){
     $result = new Matrix($matrix->rows, $matrix->cols);
     for($i =0; $i < $matrix->rows; $i++){
       for ($j =0; $j< $matrix->cols; $j++){
         $val = $matrix->matrix[$i][$j];
         $result->matrix[$i][$j] = $func($val);
       }
     }

   }


  ///instance methods

  //randomise method
  public function randomise() {
    for($i=0; $i< $this->rows; $i++) {
      for($j=0; $j<$this->cols; $j++) {
          $this->matrix[$i][$j] = (rand(20000000,80000000)/100000000);
      }
    }
  }

  //multiply method
  public function multiply($n) {
    if ($n instanceof Matrix) {
      if($this->cols == $n->cols && $this->rows == $n->rows){
        for($i =0 ; $i < $this->rows; $i++){//
           for( $j =0 ; $j < $this->cols; $j++){//
              $this->matrix[$i][$j] *= $n->matrix[$i][$j];

            }
          }
        }
      else{
        echo "Matrixs must be have same dimensions to multiply by";
      }
    }//
    else{
      for($i=0; $i< $this->rows; $i++) {
        for($j=0; $j < $this->cols; $j++) {
          $this->matrix[$i][$j] *= $n;
        }
      }
    }
 }


 //addition method

 public function add($n) {
   if ($n instanceof Matrix) {
     for($i=0; $i< $this->rows; $i++) {
       for( $j=0; $j< $this->cols; $j++) {
         $this->matrix[$i][$j] += $n->matrix[$i][$j];
       }
     }
   }else{
     for($i=0; $i < $this->rows; $i++) {
       for($j=0; $jV< $this->cols; $j++) {
         $this->matrix[$i][$j] += $n;
       }
     }
   }
 }

 //method that transposes the Matrix into a new shape

 public function transpose(){
   $result = new Matrix($this->cols, $this->rows);

   for($i = 0; $i < $this->rows; $i++){
     for( $j = 0; $j < $this->cols; $j++){
       $result->matrix[$j][$i] = $this->matrix[$i][$j];
     }
   }
   return $result;
 }

 //sigmoid function for the Matrix
 public function mapSigmoid(){
    for($i =0; $i < $this->rows; $i++){
      for ($j =0; $j< $this->cols; $j++){
        $val = $this->matrix[$i][$j];
        $this->matrix[$i][$j] = sigmoid($val);
      }
    }
 }

//de sigmoid function
 public function mapDsigmoid(){
    for($i =0; $i < $this->rows; $i++){
      for ($j =0; $j< $this->cols; $j++){
        $val = $this->matrix[$i][$j];
        $this->matrix[$i][$j] = dsigmoid($val);
      }
    }
 }

public function getMatrixIndex($rowNum , $colNum){
  return $this->matrix[$rowNum][$colNum];
}

public function changeMatrixIndex($num, $rowNum, $colNum){
   $this->matrix[$rowNum][$colNum] = $num;
}


 // function print Matrix for the viewer
 public function printMatrix(){
   for($i = 0; $i < $this->rows; $i++){
     for($j = 0; $j < $this->cols; $j++){
       echo $this->matrix[$i][$j]." ";
     }
     echo "<br>";
   }

   echo "<br><br>";
 }

 public function matrixToString(){

   $mString = "";
   for($i = 0; $i < $this->rows; $i++){


     for($j = 0; $j < $this->cols; $j++){

       //$mNum = $this->matrix[$i][$j];

        $s = strval($this->matrix[$i][$j]);

        $mString = $mString.$s;
        if($j != ($this->cols-1)){
           $mString = $mString."|";
        }

       //$mString = $mString + strval($mNum);
     }

     if($i !=($this->rows-1)){
       $mString = $mString."||";
     }



   }
    return $mString;

 }

 public function activate_func($act_func){
   if($act_func == 1){
     $this->mapSigmoid();
   }
 }

 public function inverse_func($act_func){
   if($act_func == 1){
     $this->mapDsigmoid();
   }
 }
}

//sigmoid function for a single integer
function sigmoid($x){
  return 1/(1 + exp(-$x));
}


//desigmoid function for a single integer
function dsigmoid($y){
  //return sigmoid(x)*(1-sigmoid(x));
  return $y*(1 - $y);
}
