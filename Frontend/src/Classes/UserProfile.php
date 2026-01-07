<?php

class UserProfile 
{
    //users_profiles table fields
    private ?int $user_id = null;
    private ?string $name = null;
    private ?string $surname = null;
    private ?string $gender = null;
    private ?string $birthdate = null;
    private ?string $phone = null;
    private ?string $biography = null;
    private ?string $profile_img_url = null;

    function __construct($user_id, $name = null, $surname = null, $gender = null, $birthdate = null, $phone = null, $biography = null, $profile_img_url = null)
    {
        $this->user_id = $user_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->gender = $gender;
        $this->birthdate = $birthdate;
        $this->phone = $phone;
        $this->biography = $biography;
        $this->profile_img_url = $profile_img_url;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getSurname(): ?string
    {
        return $this->surname;
    }
    public function getGender(): ?string
    {
        return $this->gender;
    }
    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getBiography(): ?string
    {
        return $this->biography;
    }
    public function getProfileImgUrl(): ?string
    {
        return $this->profile_img_url;
    }
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }
    public function setBirthdate(?string $birthdate): void
    {
        $this->birthdate = $birthdate;
    }
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
    public function setBiography(?string $biography): void
    {
        $this->biography = $biography;
    }
    public function setProfileImgUrl(?string $profile_img_url): void
    {
        $this->profile_img_url = $profile_img_url;
    }

    public function save($db)
    {
        $insert = $db->prepare("
            INSERT INTO users_profiles 
            (user_id, name, surname, gender, birthdate, phone, biography, profile_img_url)
            VALUES (:user_id, :name, :surname, :gender, :birthdate, :phone, :biography, :profile_img_url);
        ");
        $insert->execute([
            ':user_id' => $this->user_id,
            ':name' => $this->name,
            ':surname' => $this->surname,
            ':gender' => $this->gender,
            ':birthdate' => $this->birthdate,
            ':phone' => $this->phone,
            ':biography' => $this->biography,
            ':profile_img_url' => $this->profile_img_url
        ]);
    }
}