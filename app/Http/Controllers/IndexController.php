<?php

namespace App\Http\Controllers;

use App\Services\CloudfoxException;
use App\Services\Cloudfox;
use Exception;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $api_token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxMSIsImp0aSI6Ijc1YTY1ZTRjOGRjNzZmOTM0ODkyMjRiN2Y1MDRjYjNhNjI3ZDkxNGY4ZTkyZTdkMTFhN2U4NjI0Zjk4N2YzMjY5NTczYWU3NjQ2MGE0ZDc1IiwiaWF0IjoxNjI2MjEwNDE0LjUwMzY5MywibmJmIjoxNjI2MjEwNDE0LjUwMzY5NiwiZXhwIjoyNTcyODk1MjE0LjQwMTIsInN1YiI6IjI2Iiwic2NvcGVzIjpbInNhbGUiXX0.aHNP3BKTzJQxG1iKP3v4TX2qlllSJfF3rGZmQsd3hm-sL2h7DdAK_6gilYbgqr6NhK6L9I7484ah2xIr17j2DtC5Jnhr_hhfXh9wIjLF0QMrMOCEWZHEtNPpYuRhLEP2XEJWmUmDTOo3iub1JfM6dls-qTeLIjlkRmbgwbtA0I_1Tma_H_8qgvvbS6WwlSrMMDcTFqJKW0lbN4nvGbcVcT7jIaPc7TEwLdxy3ZYvb7MFqCVtBdMDeGE7GBQJonpL_uyqwKQhaASsPwX8GNthLtbaj-Q-0HdaxLCuMkTEi_reewmvVFuGETGXk46JVv786RzfONVqFjGLJ6kYTUc1mk5PuzaXPFcvajs_RFQaCGGoY3l_YAg9bsvuKSLSQh6C7en8qjOf-_st_jFEDxdjSnON9XvTsmRwu3fLmnhgqidTyV0Bd-DeqR9xhcs8COEgJ2dEx8BAYZa50gAmx6HaFd1Prh5KVtVwXb9bwxzLa1-cW8SsKkjzc0_O7QFzEuiWPtt46UV19GXNxZBgdc7XYwPlF1hLUYbl5BfBvNurOaMY3CFVZ07yXfbkuOOssfN56yamQssgjAqxISx1Y9-hv6ZgXAt9aGlPvlb6-YrLN7y37gVY83nu08JsWOgit3o1Tu0_u9Ir6aHGv4wUbToByLbSWUjQ4HG9e5GyKdSxzXw";
    private $installments_interest_free=0;

    public function payment(Request $request){
        try{
            $data = 
            [
                "payment_method"=> $request->payment_method,
                "amount"=> $request->amount,
                "installments"=>$request->installments,                
                "installments_interest_free"=> $this->installments_interest_free,
                "currency"=> "BRL",
                "invoice_description"=> "Descrição da fatura",

                "card"=> [
                    "holder_name"=> $request->card_name,
                    "number"=> $request->card_number,
                    "cvv"=> $request->card_cvv,
                    "expiration_date"=> $request->card_expiration_date
                ],

                "customer"=> [
                    "first_name"=> "Teste",
                    "last_name"=> "da Silva",
                    "name"=> "Teste da Silva",
                    "email"=> "teste@hotmail.com",
                    "document_type"=> "cpf",
                    "document_number"=> "15419563037",
                    "telephone"=> "24999999999",
                    "address"=> [
                        "street"=> "Avenida General Afonseca",
                        "number"=> "1475",
                        "complement"=> "",
                        "district"=> "Manejo",
                        "city"=> "Resende",
                        "state"=> "RJ",
                        "country"=> "Brasil",
                        "postal_code"=> "27520174"
                    ]
                ],

                "shipping_amount"=> "000",

                "items"=> [
                    [
                        "id"=> "123", //meu id
                        "name"=> "Produto de Teste",
                        "price"=> 100,
                        "quantity"=> 1,
                        "product_type"=> "physical_goods"
                    ]
                ]
            ];

            $cloudfox = new Cloudfox($this->api_token);             
            return response()->json($cloudfox->getPayment($data));

        }catch(CloudfoxException $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage(),'errors'=>$e->getErrors()],400);        
        }
    }

    public function installments(Request $request)
    {
        $data = [
            'installments'=>12, //numero maximo de parcelas
            'installments_interest_free'=>$this->installments_interest_free, //juros aplicados no parcelamento
            'amount'=>$request->amount*100 //valor a parcelar
        ];

        try{
            $cloudfox = new Cloudfox($this->api_token);            
            return $cloudfox->getInstallments($data);
        }catch(CloudfoxException $e){
            return response()->json(['status'=>'error','message'=>$e->getMessage(),'errors'=>$e->getErrors()],400);        
        }
    }
}
