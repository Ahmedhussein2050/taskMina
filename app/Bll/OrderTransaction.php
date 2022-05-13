<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Bll;

/**
 * Description of Transaction
 *
 * @author fz
 */
class OrderTransaction {

    //put your code here
   
    public $orderId="";
    public $typeId="";

    public function Save() {
        session()->put(\App\Bll\Constants::ORDER_TRANSACTION, $this);
    }

    public function get() {
        return session()->get(\App\Bll\Constants::ORDER_TRANSACTION);
    }

    public function destroy() {
        if ($this->get() !== null)
            session()->remove(\App\Bll\Constants::ORDER_TRANSACTION);
    }

}
