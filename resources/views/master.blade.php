<!DOCTYPE html>
<html>
    <head>
        <title>Example Cloudfox Api checkout integration</title>  
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/index.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    
        <script type="text/javascript" src="js/index.js?v=1" defer></script>

        <meta name="csrf-token" content="{{csrf_token()}}">
    </head>
<body class="bg-light">
    <div class="container">
        <main>
            <!-- Shopping Cart -->
            <section class="shopping-cart box">
                <div class="box-header">
                    <h2>Carrinho de Compras</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8 py-3">
                            <div class="row justify-content-md-center">
                                <div class="col-md-3">
                                    <img class="img-fluid mx-auto d-block image" src="img/product.jpg">
                                </div>
                                <div class="col-md-4">
                                    <h5 class="pt-4">Produto</h5>
                                    <div class="product-info">
                                        <p><b>Descrição: </b><span id="product-description">Produto de Teste </span><br>
                                        <b>Tamanho: </b>M<br>
                                        <b>Cor: </b>Verde<br>
                                        <b>Preço:</b> R$ <span id="unit-price">100</span></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="quantity"  class="pt-4"><h5>Quantidade</h5></label>
                                    <input type="number" id="quantity" value="1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 px-0">
                            <div class="summary">
                                <h3>Carrinho</h3>
                                <div class="summary-item">
                                    <span class="text">Subtotal</span><span class="price" id="cart-total"></span>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" id="checkout-btn">Continuar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--payment-->
            <section class="payment-form box">
                <div class="box-header">
                    <h2>Formas de Pagamento</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                </div>
                <div class="box-content cloudfox">
                    <div class="row">
                        <div class="col-md-12 col-lg-8 py-3 px-5">
                            <h4>Selecione uma forma de pagamento</h4>
                            <br/>
                            <ul class="options-list ui-card">
                                <li class="options-list__item" id="item-credit-card" payment_method="credit_card">
                                    <input type="radio" class="u-hide" id="new_card_row" name="payment_method" value="credit_card">
                                    <label class="options-list__label " for="new_card_row">
                                        <div class="group-media-object">
                                            <div>
                                                <div class="icon-wrapper">
                                                    <svg width="26px" height="16px" viewBox="0 0 26 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">                              
                                                        <title>5C4056CA-2311-4909-8339-5342C2FD0579</title>
                                                        <desc>Created with sketchtool.</desc>
                                                        <g id="CloudFox" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <g id="Checkout-03" transform="translate(-393.000000, -354.000000)">
                                                                <g id="Group-7" transform="translate(114.000000, 100.000000)">
                                                                    <g id="Group-11" transform="translate(31.000000, 214.000000)">
                                                                        <g id="card_icon" transform="translate(248.000000, 40.000000)">
                                                                            <path d="M0.5,1.99406028 L0.5,14.0059397 C0.5,14.829848 1.17073661,15.5 1.99700466,15.5 L24.0029953,15.5 C24.8293853,15.5 25.5,14.83058 25.5,14.0059397 L25.5,1.99406028 C25.5,1.17015195 24.8292634,0.5 24.0029953,0.5 L1.99700466,0.5 C1.17061467,0.5 0.5,1.16941998 0.5,1.99406028 Z" id="Rectangle-4" stroke="#323C45" opacity="0.5"></path>
                                                                            <rect id="Rectangle-5" fill-opacity="0.5" fill="#323C45" x="4.81481481" y="4" width="4.81481481" height="3" rx="1"></rect>
                                                                            <path d="M5.77777778,11 L21.1851852,11" id="Line" stroke="#788995" stroke-linecap="square"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="row-details">
                                                <div class="title"><span>Cartão de Crédito</span></div>
                                                <div class="text"><span>Parcela suas compras</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                                <li class="options-list__item item-boleto" payment_method="boleto">
                                    <input type="radio" class="u-hide" id="boleto" name="payment_method" value="boleto">
                                    <label class="options-list__label" for="boleto">
                                        <div class="group-media-object">
                                            <div>
                                                <div class="icon-wrapper">
                                                <svg id="boleto" xmlns="http://www.w3.org/2000/svg" width="89.268" height="59.512" viewBox="0 0 89.268 59.512">
                                                <g id="billet">
                                                    <path id="Path" d="M89.268,52.073a7.461,7.461,0,0,1-7.439,7.439H7.439A7.461,7.461,0,0,1,0,52.073V7.439A7.461,7.461,0,0,1,7.439,0h74.39a7.461,7.461,0,0,1,7.439,7.439Z" fill="#f5f5f5" fill-rule="evenodd"/>
                                                    <path id="Shape" d="M81.829,0H7.439A7.461,7.461,0,0,0,0,7.439V52.073a7.461,7.461,0,0,0,7.439,7.439h74.39a7.461,7.461,0,0,0,7.439-7.439V7.439A7.461,7.461,0,0,0,81.829,0Zm0,1.488A5.957,5.957,0,0,1,87.78,7.439V52.073a5.957,5.957,0,0,1-5.951,5.951H7.439a5.957,5.957,0,0,1-5.951-5.951V7.439A5.957,5.957,0,0,1,7.439,1.488Z" fill="#d0d0d0"/>
                                                    <path id="Path-2" data-name="Path" d="M27.372,19.705h2.967V49.9H27.372Z" transform="translate(-7.01 -5.046)" fill-rule="evenodd"/>
                                                    <path id="Path-3" data-name="Path" d="M51.907,19.705h2.967V49.9H51.907Z" transform="translate(-13.293 -5.046)" fill-rule="evenodd"/>
                                                    <path id="Path-4" data-name="Path" d="M72.314,19.705h2.967V49.9H72.314Z" transform="translate(-18.519 -5.046)" fill-rule="evenodd"/>
                                                    <path id="Path-5" data-name="Path" d="M80.43,19.705H83.4V49.9H80.43Z" transform="translate(-20.598 -5.046)" fill-rule="evenodd"/>
                                                    <path id="Path-6" data-name="Path" d="M88.639,19.705h2.967V49.9H88.639Z" transform="translate(-22.7 -5.046)" fill-rule="evenodd"/>
                                                    <path id="Path-7" data-name="Path" d="M60.023,19.705h6.035V49.9H60.023Z" transform="translate(-15.372 -5.046)" fill-rule="evenodd"/>
                                                    <path id="Path-8" data-name="Path" d="M35.535,19.705h9.07V49.9h-9.07Z" transform="translate(-9.1 -5.046)" fill-rule="evenodd"/>
                                                </g>
                                                </svg>
                        
                                                </div>
                                            </div>
                                            <div>
                                                <div class="row-details">
                                                <div class="title"><span>Boleto bancário</span></div>
                                                <div class="text"><span>O pagamento será aprovado em 1 ou 2 dias úteis.</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                                <li class="options-list__item item-pix" payment_method="pix">
                                    <input type="radio" class="u-hide" id="pix" name="payment_method" value="pix">
                                    <label class="options-list__label" for="pix">
                                        <div class="group-media-object">
                                            <div>
                                                <div class="icon-wrapper">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="38.867" height="40.868" viewBox="0 0 38.867 40.868">
                                                        <g id="Grupo_61" data-name="Grupo 61" transform="translate(-2948.5 213.743)">
                                                            <g id="g992" transform="translate(2956.673 -190.882)">
                                                            <path id="path994" d="M-73.541-25.595a5.528,5.528,0,0,1-3.933-1.629l-5.68-5.68a1.079,1.079,0,0,0-1.492,0l-5.7,5.7a5.529,5.529,0,0,1-3.934,1.628H-95.4l7.193,7.194a5.753,5.753,0,0,0,8.136,0l7.214-7.214Z" transform="translate(95.4 34.202)" fill="none" stroke="#3a506c" stroke-width="1"/>
                                                            </g>
                                                            <g id="g996" transform="translate(2956.673 -212.243)">
                                                            <path id="path998" d="M-3.765-29.869A5.528,5.528,0,0,1,.169-28.24l5.7,5.7a1.056,1.056,0,0,0,1.493,0l5.68-5.68a5.529,5.529,0,0,1,3.934-1.629h.684l-7.214-7.214a5.753,5.753,0,0,0-8.136,0l-7.193,7.193Z" transform="translate(4.884 37.747)" fill="none" stroke="#3a506c" stroke-width="1"/>
                                                            </g>
                                                            <g id="g1000" transform="translate(2949 -201.753)">
                                                            <path id="path1002" d="M-121.731-14.725l-4.36-4.359a.83.83,0,0,1-.31.063h-1.982a3.917,3.917,0,0,0-2.752,1.14l-5.68,5.68a2.718,2.718,0,0,1-1.927.8,2.719,2.719,0,0,1-1.928-.8l-5.7-5.7a3.917,3.917,0,0,0-2.752-1.14h-2.437a.827.827,0,0,1-.293-.059l-4.377,4.377a5.753,5.753,0,0,0,0,8.136l4.377,4.377a.828.828,0,0,1,.293-.059h2.437a3.917,3.917,0,0,0,2.752-1.14l5.7-5.7a2.792,2.792,0,0,1,3.856,0l5.68,5.679a3.917,3.917,0,0,0,2.752,1.14h1.982a.83.83,0,0,1,.31.062l4.359-4.359a5.753,5.753,0,0,0,0-8.136" transform="translate(157.913 19.102)" fill="none" stroke="#3a506c" stroke-width="1"/>
                                                            </g>
                                                        </g>
                                                    </svg>                    
                                                </div>
                                            </div>
                                            <div>
                                                <div class="row-details">
                                                    <div class="title"><span>Pix</span></div>
                                                    <div class="text"><span>Após geração do QrCode você terá até 1h para finalizar seu pagamento.</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                            </ul>                            
                        </div>
                        <div class="col-md-12 col-lg-4 px-0">
                            <div class="summary">
                                <h3>Resumo</h3>
                                <div class="summary-item">
                                    <p>
                                        <span class="text">Produto de teste x <span class="summary-quantity"></span> </span><span class="price summary-price"></span>
                                    </p>
                                    <p>
                                        <span class="text">Total</span><span class="price summary-total"></span>
                                    </p>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" id="go-back">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 10 10" class="chevron-left">
                                        <path fill="#ff4e05" fill-rule="nonzero"id="chevron_left" d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>
                                        </svg>
                                        Voltar para o carrinho
                                    </button>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>  
            <!-- credit card -->
            <section class="payment-credit-card box">
                <div class="box-header">
                    <h2>Pagamento com Cartão de crédito</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8 py-3 px-5">
                            <form action="/payment">
                                <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <label for="">Número do cartão de crédito</label>
                                    <input type="text" class="form-control" name="number_card">
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label for="">Nome impresso no cartão</label>
                                    <input type="text" class="form-control" name="holder_card">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="">Validade Cartão</label>
                                    <input type="text" class="form-control" name="validate_card">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="">Cód. Segurança</label>
                                    <input type="text" class="form-control" name="validate_card">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="">Parcelamento</label>
                                    <input type="text" class="form-control" name="installments_card">
                                    </div>
                                </div>
                                </div>
                            </form>
                            <br/>
                            <a href id="go-back" class="link-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 10 10" class="chevron-left">
                                <path fill="#ff4e05" fill-rule="nonzero"id="chevron_left" d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>
                                </svg>
                                Voltar para tela anterior
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-4 px-0">
                            <div class="summary">
                                <h3>Resumo</h3>
                                <div class="summary-item">
                                    <p>
                                        <span class="text">Produto de teste x <span class="summary-quantity"></span> </span><span class="price summary-price"></span>
                                    </p>
                                    <p>
                                        <span class="text">Total</span><span class="price summary-total"></span>
                                    </p>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary">Finalizar Compra</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
             
            </section>    

            <!-- boleto -->
            <section class="payment-boleto box">
                <div class="box-header">
                    <h2>Pagamento com Boleto</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8 py-3 px-5">
                            <div class="row">
                                <div class="col-12">
                                    <p class="obs">
                                        Os pagamentos efetuados via Boleto Bancário não podem ser parcelados. Seu produto será
                                        reservado e enviado <strong>somente após a confirmação do pagamento</strong> do boleto.
                                    </p>
                                    <p class="information"><strong>Lembre-se:</strong></p>
                                    <div class="alert alert-secondary" role="alert">
                                        <ul>
                                            <li>Você deve pagar seu boleto até a data de vencimento;</li>
                                            <li>O pagamento leva em torno de 2 dias úteis para ser processado;</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>        
                            <a href id="go-back" class="link-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 10 10" class="chevron-left">
                                <path fill="#ff4e05" fill-rule="nonzero"id="chevron_left" d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>
                                </svg>
                                Voltar para tela anterior
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-4 px-0">
                            <div class="summary">
                                <h3>Resumo</h3>
                                <div class="summary-item">
                                    <p>
                                        <span class="text">Produto de teste x <span class="summary-quantity"></span> </span><span class="price summary-price"></span>
                                    </p>
                                    <p>
                                        <span class="text">Total</span><span class="price summary-total"></span>
                                    </p>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary">Finalizar Compra</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
             
            </section>

            <!-- pix -->
            <section class="payment-pix box">
                <div class="box-header">
                    <h2>Pagamento com Pix</h2>
                    <p>This is an example of Api Checkout of Cloudfox</p> 
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12 col-lg-8 py-3 px-5">
                            <div class="text-center">
                                <img src="img/qr_code_example.png" class="rounded" alt="...">
                                <p>Se preferir, pague com a opção <strong>PIX Copia e Cola</strong>:</p>
                                <input type="text" class="form-control" name="qr-code">
                            </div>  
                            <br/> 
                            <a href id="go-back" class="link-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 10 10" class="chevron-left">
                                <path fill="#ff4e05" fill-rule="nonzero"id="chevron_left" d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>
                                </svg>
                                Voltar para tela anterior
                            </a>
                        </div>
                        <div class="col-md-12 col-lg-4 px-0">
                            <div class="summary">
                                <h3>Resumo</h3>
                                <div class="summary-item">
                                    <p>
                                        <span class="text">Produto de teste x <span class="summary-quantity"></span> </span><span class="price summary-price"></span>
                                    </p>
                                    <p>
                                        <span class="text">Total</span><span class="price summary-total"></span>
                                    </p>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary">Finalizar Compra</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
             
            </section>
        </main>
    </div>
    <footer class="p-4 bg-white">
        <div class="row px-3">
            <div class="col-4 col-md-1">
                <img src="img/logo.svg" class="img-fluid">
            </div>
            <div class="col-1 col-md-6"></div>
            <div class="col-7 col-md-5 text-end">
                <p>Site: <a href="https://cloudfox.net">https://cloudfox.net</p>
            </div>
        </div>                
	</footer>
  </body>
</html>