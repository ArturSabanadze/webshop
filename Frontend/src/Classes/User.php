<?php

class User
{
//user table fields
private $id = "";
private $username = "";
private $password_hash = "";
private $email = "";
//users_profiles table fields
private $role = "";
private $name = "";
private $surname = "";
private $gender = "";
private $birthdate = "";
private $phone = "";
private $biography = "";
private $profile_img_url = "";
//users_addresses table fields
private $type = ""; //Adress type: billing/shipping
private $zip_code = "";
private $country = "";
private $street = "";
private $street_number = "";
private $state = "";
private $province = "";

//Methoden, Funktionen - Getter/Setter
	public function getName()
	{
		return $this->name;
	}

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function getBiography()
    {
        return $this->biography;
    }
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }
    public function getProfileImgUrl()
    {
        return $this->profile_img_url;
    }
    public function setProfileImgUrl($profile_img_url)
    {
        $this->profile_img_url = $profile_img_url;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getPasswordHash()
    {
        return $this->password_hash;
    }
    public function setPasswordHash($password_hash)
    {
        $this->password_hash = $password_hash;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getZipCode()
    {
        return $this->zip_code;
    }
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
    public function getStreet()
    {
        return $this->street;
    }
    public function setStreet($street)
    {
        $this->street = $street;
    }
    public function getStreetNumber()
    {
        return $this->street_number;
    }
    public function setStreetNumber($street_number)
    {
        $this->street_number = $street_number;
    }
    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
    public function getProvince()
    {
        return $this->province;
    }
    public function setProvince($province)
    {
        $this->province = $province;
    }
    

}

//Instanziieren
$person = new Person();
$person2 = new Person();
echo gettype($person);
echo "<br>";

var_dump($person);
//object(Person)#1 (2) { ["vorname"]=> string(0) "" ["nachname"]=> string(0) "" }
echo "<br>";
var_dump($person2);
echo "<br>";
$person->vorname = "John";
$person->nachname = "Doe";
var_dump($person);
echo "<br>";
//object(Person)#1 (2) { ["vorname"]=> string(4) "John" ["nachname"]=> string(3) "Doe" }
echo "Hallo " . $person->vorname . " " . $person->nachname;



#echo Person::$vorname;
?>