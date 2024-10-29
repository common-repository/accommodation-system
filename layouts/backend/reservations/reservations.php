<?php

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    if (!class_exists('Reservations')){
        class Reservations extends Controller{

            function __construct(){
                parent::__construct();
            }

            public static function reservations_layout(){
                echo 'hello! here is the reservations page - coming <b>Soon</b> !';
            }

        }
    }