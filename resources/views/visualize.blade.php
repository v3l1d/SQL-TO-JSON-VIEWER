<!DOCTYPE html>
@extends('welcome')



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


<script type="text/javascript">



$.ajax({
  method:'GET',
  url:'http://localhost:3000',
  success:function(elements){
    console.log(elements);
  }
});





</script>
