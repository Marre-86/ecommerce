@extends('layouts.main')
@section('content')
<link href="{{ asset('prism.css') }}" rel="stylesheet" />
<script src="{{ asset('prism.js') }}"></script>
<div class="w-60">
    <div class="card" style="margin-bottom:1rem; min-width:fit-content;">
        <div class="card-header">
                <h3>Main Page</h3>
        </div>
        <div style="padding: 2rem 0.5rem 0 0.5rem; overflow: auto">
            <p style="margin-left:2rem">Below there is a list of API requests you can send to this service.</p>

            <div class="accordion" id="accordionExample">

                <div class="acc-code">
                    <p class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed acc-post" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                          <div class="acc-header-content">
                            <span class="text-primary">POST api/v1/register</span>
                            <span class="acc-header-text">&nbsp;– sign up for this application. Example of the request:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['register_request'] }}</code></pre>
                            <p>Example of the response:</p> 
                            <pre class="code"><code class="language-json">{{ $jsonSamples['register_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed acc-post" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                          <div class="acc-header-content">
                            <span class="text-primary">POST /api/v1/login</span>
                            <span class="acc-header-text">&nbsp;– log in to this application. Example of the request:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['login_request'] }}</code></pre>
                            <p>Example of the response:</p> 
                            <pre class="code"><code class="language-json">{{ $jsonSamples['login_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed acc-get" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                          <div class="acc-header-content">
                            <span class="text-primary">GET /api/v1/listing-categories</span>
                            <span class="acc-header-text">&nbsp;– returns a tree of categories (nested structure). Example of the response:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['category_tree'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed acc-post" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          <div class="acc-header-content">    
                            <span class="text-primary">POST /api/v1/category</span>
                            <span class="acc-header-text">&nbsp;– adds a new category. Requires authorization. Example of the request:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['category_post_request'] }}</code></pre>
                            <p>Example of the response:</p> 
                            <pre class="code"><code class="language-json">{{ $jsonSamples['category_post_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed acc-get" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          <div class="acc-header-content">
                            <span class="text-primary">GET /api/v1/products</span>
                            <span class="acc-header-text">&nbsp;– returns a list of products in the database. The following query parameters for filtering are available:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li><p><span class="text-warning">filter[name]</span> – selection of the products those names have been specified by a user;</li>
                                <li><p><span class="text-warning">filter[category_id]</span> – selection of the products with requested category_id;</li>
                                <li><p><span class="text-warning">filter[price-gte]</span> – selection  of the products whose price is greater than requested;</li>
                                <li><p><span class="text-warning">filter[price-lte]</span> – selection of the products whose price is lower than requested;</li>
                                <li><p><span class="text-warning">filter[weight]</span> – selection of the products with requested weight;</li>
                                <li><p><span class="text-warning">filter[length]</span> – selection of the products with requested length;</li>
                                <li><p><span class="text-warning">filter[width]</span> – selection of the products with requested width;</li>
                            </ul>
                            <p>Example of the response:</p> 
                            <pre class="code"><code class="language-json">{{ $jsonSamples['products_get'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed acc-get" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                          <div class="acc-header-content">    
                            <span class="text-primary">GET /api/v1/cart</span>
                            <span class="acc-header-text">&nbsp;– returns the content of the shopping cart. Requires authorization. Example of the response:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['cart_get_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed acc-post" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                          <div class="acc-header-content">    
                            <span class="text-primary">POST /api/v1/cart</span>
                            <span class="acc-header-text">&nbsp;– adds a product with specified id into the cart. Requires authorization. Example of the request:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['cart_post_request'] }}</code></pre>
                            <p>If quantity hasn't been specified, one item will be added.<br>Returns updated content of the cart. Example of the response:</p> 
                            <pre class="code"><code class="language-json">{{ $jsonSamples['cart_post_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed acc-patch" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                          <div class="acc-header-content">    
                            <span class="text-primary">PATCH /api/v1/cart</span>
                            <span class="acc-header-text">&nbsp;– updates the quantity of a product with specified id into the cart. Requires authorization. Example of the request:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['cart_patch_request'] }}</code></pre>
                            <p>If "0" is specified as quantity of an updated product, then it will be removed from the cart.<br>Returns updated content of the cart. Example of the response:</p> 
                            <pre class="code"><code class="language-json">{{ $jsonSamples['cart_patch_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingNine">
                        <button class="accordion-button collapsed acc-delete" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                          <div class="acc-header-content">    
                            <span class="text-primary">DELETE /api/v1/cart/:id</span>
                            <span class="acc-header-text">&nbsp;– removes product with specified id from the cart. Requires authorization. Returns updated content of the cart. Example of the response:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['cart_delete_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed acc-post" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                          <div class="acc-header-content">    
                            <span class="text-primary">POST /api/v1/orders</span>
                            <span class="acc-header-text">&nbsp;– creates a new order consisting of all items in the Cart. Requires authorization. Example of the request (fields 'phone' and 'description' are optional):</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json" style="white-space: pre-wrap;">{{ $jsonSamples['order_post_request'] }}</code></pre>
                            <p>Returns basic information about an order. Example of the response:</p>
                            <pre class="code"><code class="language-json" style="white-space: pre-wrap;">{{ $jsonSamples['order_post_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingEleven">
                        <button class="accordion-button collapsed acc-get" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                          <div class="acc-header-content">    
                            <span class="text-primary">GET /api/v1/orders</span>
                            <span class="acc-header-text">&nbsp;– returns list of orders made by authenthiticated user. Requires authorization. Example of the response:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json" style="white-space: pre-wrap;">{{ $jsonSamples['orders_get_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingTwelwe">
                        <button class="accordion-button collapsed acc-get" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelwe" aria-expanded="false" aria-controls="collapseTwelwe">
                          <div class="acc-header-content">    
                            <span class="text-primary">GET /api/v1/orders/:id</span>
                            <span class="acc-header-text">&nbsp;– returns detailed info about the order of authenthiticated user by ID. Requires authorization. Example of the response:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseTwelwe" class="accordion-collapse collapse" aria-labelledby="headingTwelwe" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json" style="white-space: pre-wrap;">{{ $jsonSamples['specific_order_response'] }}</code></pre>
                        </div>
                    </div>
                </div>

                <div class="acc-code">
                    <p class="accordion-header" id="headingThirteen">
                        <button class="accordion-button collapsed acc-delete" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                          <div class="acc-header-content">    
                            <span class="text-primary">DELETE /api/v1/orders/:id</span>
                            <span class="acc-header-text">&nbsp;– deletes the order of authenthiticated user by ID (if it hasn't been confirmed yet). Requires authorization. Example of the response:</span>
                          </div>
                        </button>
                    </p>
                    <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <pre class="code"><code class="language-json">{{ $jsonSamples['order_delete_response'] }}</code></pre>
                            <p>If order has already been confirmed, the error message returns:</p> 
                            <pre class="code"><code class="language-json" style="white-space: pre-wrap;">{{ $jsonSamples['order_delete_response_error'] }}</code></pre>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection