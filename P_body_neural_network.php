<?php
include 'P_body_matrix.php';

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
