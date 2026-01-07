<?php

class UserAddress 
{
    private ?int $id = null;
    private int $user_id;
    private ?string $type;
    private ?string $street;
    private ?string $street_number;
    private ?string $state;
    private ?string $province;
    private ?string $country;
    private ?string $zip_code;

    function __construct($user_id, $type = null, $street = null, $street_number = null, $state = null, $province = null, $country = null, $zip_code = null)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->street = $street;
        $this->street_number = $street_number;
        $this->state = $state;
        $this->province = $province;
        $this->country = $country;
        $this->zip_code = $zip_code;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
    public function gettype(): ?string
    {
        return $this->type;
    }
    public function getStreet(): ?string
    {
        return $this->street;
    }
    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }
    public function getState(): ?string
    {
        return $this->state;
    }
    public function getProvince(): ?string
    {
        return $this->province;
    }
    public function getCountry(): ?string
    {
        return $this->country;
    }
    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }
    public function settype(?string $type): void
    {
        $this->type = $type;
    }
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }
    public function setStreetNumber(?string $street_number): void
    {
        $this->street_number = $street_number;
    }
    public function setState(?string $state): void
    {
        $this->state = $state;
    }
    public function setProvince(?string $province): void
    {
        $this->province = $province;
    }
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }
    public function setZipCode(?string $zip_code): void
    {
        $this->zip_code = $zip_code;
    }

    public function save($db)
    {
        $insert = $db->prepare("
            INSERT INTO users_addresses 
            (user_id, type, street, street_number, state, province, country, zip_code)
            VALUES (:user_id, :type, :street, :street_number, :state, :province, :country, :zip_code);
        ");
        $insert->execute([
            ':user_id' => $this->user_id,
            ':type' => $this->type,
            ':street' => $this->street,
            ':street_number' => $this->street_number,
            ':state' => $this->state,
            ':province' => $this->province,
            ':country' => $this->country,
            ':zip_code' => $this->zip_code
        ]);
    }
}