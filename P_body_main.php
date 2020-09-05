<?php

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
       $this->matrix[$i] = [];
       for($j=0; $j<$this->cols; $j++) {
           $this->matrix[$i][$j] = 0;
       }
     }
  }


  ///static methods

  //static multiply method
  public static function staticMultiply($m1, $m2){
    if($m1->cols != $m2->rows){
      echo 'colums of m1 must equal rows of m2';
      return undefined;
    }else{//
      $result = new Matrix($m1->rows, $m2->cols);
      for($i =0 ; $i < $result->rows; $i++){//
        for( $j =0 ; $j < $result->cols; $j++){//
           $sum = 0;
           for($k = 0; $k < $m1->cols; $k++){//
             $sum = $sum + $m1->matrix[$i][$k] * $m2->matrix[$k][$j];
           }//
           $result->matrix[$i][$j] = $sum;
          }//
        }//
      return $result;
    }//
  }


  //static subrtact method

  public static function staticSubtract($a, $b){
     $result = new Matrix($a->rows, $a->cols);
     for($i = 0; $i < $result->rows; $i++){
        for( $j =0; $j < $result->cols; $j++){
          $result->matrix[$i][$j] = $a->matrix[$i][$j] - $b->matrix[$i][$j];
        }
      }
      return $result;
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
    if ($n instanceof Matrix) {//
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

class P_body_network {

 //instance methods
  public $learning_rate;
  public $hidden_array_weights = array();
  public $array_bias =array();


  //constructor
   public function __construct($arr){


     //set learning rate
     $this->learning_rate = 0.5;

     $this->activation_function = 1;



    //for each number in the Matrix
     for($i = 0; $i < (sizeof($arr)-1); $i++){
       if(is_int($arr[$i]) && is_int($arr[$i+1])){
         $newMatrix = new Matrix($arr[$i+1], $arr[$i]); //create a Matrix representing the weights
         $newMatrix->randomise(); //randomise weights
         $newBias = new Matrix($arr[$i+1], 1); // create a Matrix representing the bias
         $newBias->randomise(); //randomise bias

         //push the bias Matrices and weight Matrices into respective arrays
         array_push($this->hidden_array_weights, $newMatrix);
         array_push($this->array_bias, $newBias);
       }else{
         throw new Exception("invalid data in array");
       }
     }
   }



  //feedforward function
   public function feedforward($input_array){
     $act_func = $this->activation_function;



     //this array is not an instance variable but is temporary store of hidden values for the purpose of feedforward calculations
     $arr = array();

     //for  loop that goes through each layer of Neural Network performing a specific set of calculations as it goes through the network
     for($i = 0; $i < sizeof($this->hidden_array_weights); $i++){
       if($i == 0){
         $inputs = Matrix:: fromArray($input_array);
         $hidden1 = Matrix:: staticMultiply($this->hidden_array_weights[$i], $inputs);
         $hidden1->add($this->array_bias[$i]);
         $hidden1->mapSigmoid();
         array_push($arr, $hidden1);
       }elseif($i == (sizeof($this->hidden_array_weights)-1)){
         $output = Matrix :: staticMultiply($this->hidden_array_weights[$i], $arr[$i-1]);
         $output->add($this->array_bias[$i]);
         $output->mapSigmoid();
         $output->printMatrix();
       }else{
         $hidden2 = Matrix :: staticMultiply($this->hidden_array_weights[$i], $arr[$i-1]);
         $hidden2->add($this->array_bias[$i]);
         $hidden2->mapSigmoid();
         array_push($arr, $hidden2);
       }
     }
   }


  //train function
   public function train($input_array, $target_array){

      // I am aware that the following function is identical to the feedforward function and hence could be condensed However the feedforward function displays the output, this doesnt
      //so I kept the two functions different for current convenience this will be fixed later.
     $act_func = $this->activation_function;



      //this array is not an instance variable but is temporary store of hidden values for the purpose of feedforward and backward propagation calculations
      $arr = array();

      for($i = 0; $i < sizeof($this->hidden_array_weights); $i++){
        if($i == 0){
          $inputs = Matrix::fromArray($input_array);
          $hidden1 = Matrix:: staticMultiply($this->hidden_array_weights[$i], $inputs);
          $hidden1->add($this->array_bias[$i]);
          $hidden1->mapSigmoid();
          array_push($arr, $hidden1);
        }elseif($i == (sizeof($this->hidden_array_weights)-1)){
          $output = Matrix :: staticMultiply($this->hidden_array_weights[$i], $arr[$i-1]);
          $output->add($this->array_bias[$i]);

          $output->mapSigmoid();

        }else{
          $hidden2 = Matrix :: staticMultiply($this->hidden_array_weights[$i], $arr[$i-1]);
          $hidden2->add($this->array_bias[$i]);
          $hidden2->mapSigmoid();
          array_push($arr, $hidden2);
        }
      }


      $targets = Matrix :: fromArray($target_array);
      $output_errors = Matrix :: staticSubtract($targets, $output);



      //like the feedforward algorithm the backward propagation also uses a for loop only this time it moves through the network in the opposite direction
      for($i = (sizeof($this->hidden_array_weights)-1); $i >= 0; $i--){
        if($i == (sizeof($this->hidden_array_weights)-1)){
          $output->mapDsigmoid();
          $output->multiply($output_errors);
          $output->multiply($this->learning_rate);

          $t = $arr[$i-1]->transpose();
          $deltas = Matrix :: staticMultiply($output, $t);

          $this->hidden_array_weights[$i]->add($deltas);



          $t = $this->hidden_array_weights[$i]->transpose();
          $hidden_errors = Matrix :: staticMultiply($t, $output_errors);
        }elseif($i == 0){
          $arr[$i]->mapDsigmoid();
          $arr[$i]->multiply($hidden_errors);
          $arr[$i]->multiply($this->learning_rate);

          $t = $inputs->transpose();
          $deltas = Matrix :: staticMultiply($arr[$i], $t);

          $this->hidden_array_weights[$i]->add($deltas);


        }else{

          $arr[$i]->mapDsigmoid();
          $arr[$i]->multiply($hidden_errors);
          $arr[$i]->multiply($this->learning_rate);



          $t = $arr[$i-1]->transpose();
          $deltas = Matrix :: staticMultiply($arr[$i], $t);

          $this->hidden_array_weights[$i]->add($deltas);


          $t = $this->hidden_array_weights[$i]->transpose();
          $hidden_errors = Matrix :: staticMultiply($t, $hidden_errors);
        }
      }
    }


    public function set_learning_rate($learning_rate){
      if(is_int($learning_rate)){
        $this->learning_rate = $learning_rate;
      }else{
        throw new Exception("Input Value must be an integer");
      }

    }
 }

?>
