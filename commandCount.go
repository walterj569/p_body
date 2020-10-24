package main

//import packages
import "fmt"
import "os"
import "strconv"


func main(){
  
  //get input from command line arguments
  var input = os.Args

  //check length of input
  if(len(input)!=2){
    os.Exit(1)
  }

  //convert input to an integer
  n, err:= strconv.Atoi(input[1])
  
   
  if(err!= nil){
    os.Exit(2)// if input cannot be converted to integer throw an error
  }else{

     var i int //declare int variable for a for loop

     for i = 1; i <= n ; i++{

       if((i%3 == 0)&&(i%5 == 0)){
         fmt.Println("ThreeFive")
       }else if(i%3==0){
         fmt.Println("Three")
       }else if(i%5 == 0){
         fmt.Println("Five")
       }else{
        fmt.Println(i)
       }
     }
     //for loop that goes through number one to N printing them off. if statements process inputs to see
     // if they are a multiple of 3, 5 or both
  }

}
