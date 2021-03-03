<?php


namespace App\Models;


class User extends Model
{
    public function getData($email,$number="")
    {
        if($email!=null) {
            return $this->qb
                ->select('*')
                ->from("users")
                ->where('email', '=', $email)
                ->exec();
        }
        elseif ($number!=""){
            return $this->qb
                ->select('*')
                ->from("users")
                ->where('number', '=', $number)
                ->exec();
        }
    }

    public function setData($firstName, $lastName, $email, $pass,$number){
        return $this->qb
            ->insert("users",array('first_name','last_name','email','password','number'))
            ->values(array($firstName,$lastName,$email,$pass,$number))
            ->exec();
    }
}