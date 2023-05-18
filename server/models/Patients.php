<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Patients extends Model
{
    public $name;
    public $sex;
    public $religion;
    public $phone;
    public $address;
    public $nik;

    public function validation()
    {
      $validator = new Validation();

        $validator->add(
              "name",
              new PresenceOf(array(
                "message" => "name is required"
              )
          )
        );

        $validator->add(
              "sex",
              new PresenceOf(array(
                "message" => "sex is required"
              )
          )
        );

        $validator->add(
              "sex",
              new InclusionIn(
                array(
                  'message' => 'Sex must be a Male or Female',
                  'domain' => [
                      'Male',
                      'Female'
                  ],
                )
              )
        );

        $validator->add(
              "religion",
              new PresenceOf(array(
                "message" => "religion is required"
              )
          )
        );

        $validator->add(
              "phone",
              new PresenceOf(array(
                "message" => "phone is required"
              )
          )
        );
        $validator->add(
              "address",
              new PresenceOf(array(
                "message" => "address is required"
              )
          )
        );

        $validator->add(
              "nik",
              new PresenceOf(array(
                "message" => "nik is required"
              )
          )
        );

        $validator->add(
              "nik",
              new Uniqueness(array(
                "field" => "nik",
                "message" => "The nik must be unique"
              )
          )
        );

      return $this->validate($validator);
    }
}