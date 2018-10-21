<?php
/*
written by Steven L. Fuchs

DOCUMENATION:
-------------------------------------------------------
the function "bitsum" generates a single bitcode from
a sum of the given string

the function "bitstr" generate a string of bitcodes
by generating a sum and calculating a bitcode for
every letter

both functions take a string which is used to generate
a sum as first parameter and a integer as second and
optional parameter to define the length of the bitcode
which is by default set to 8

the function "__gennums" is used by the two other
functions to generate a table/array of numbers which
is used to calculate the bitcode

for generating the sum the built in function "ord"
is used which returns the value of a ascii-character

this means you can only pass string with valid
ascii-characters to this function!!!

*/

function __gennums(int $length){
	/*

	this function generates a table of numbers used
	to calculate bitcodes

	for example
	$nums = [128,64,32,16,8,4,2,1];
	is a table for octets

	*/
	if(empty($length)){
		return null;
	}

	//generate octet nums
	$nums = [];
	$num = 1;
	while(count($nums)<$length){
		array_push($nums, $num);
		$num *= 2;
	}

	//reverse nums
	$backup = $nums;
	$nums = [];
	for($index = count($backup) - 1; $index >= 0; $index--){
		array_push($nums, $backup[$index]);
	}

	return $nums;
}

function bitsum(string $str, int $length=8) {
	//check if args aren't empty
	if(empty($str) || empty($length)){
		return null;
	}

	//generate nums
	$nums = __gennums($length);

	//generate sum
	$sum = 0;
	foreach (str_split($str) as $letter) {
		$sum += ord($letter);
	}

	//generate octet/bitcode
	$code = "";
	foreach ($nums as $num) {
		if($sum-$num<0){
			$code .= "0";
		}else{
			$sum -= $num;
			$code .= "1";
		}
	}

	return $code;
}

function bitstr(string $str, int $length=8) {
	//check if args aren't empty
	if(empty($str) || empty($length)){
		return null;
	}

	//generate nums
	$nums = __gennums($length);

	//generate string of octets/bitcodes
	$code = "";
	foreach(str_split($str) as $letter){
		//get sum
		$sum = ord($letter);

		//generate octet/bitcode
		foreach ($nums as $num) {
			if($sum-$num<0){
				$code .= "0";
			}else{
				$sum -= $num;
				$code .= "1";
			}
		}
	}

	return $code;
}
?>
