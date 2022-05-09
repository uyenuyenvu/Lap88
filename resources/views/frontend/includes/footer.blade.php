<footer>
            <div class="footer-container white-bg">
                <!--Footer Top Area Start-->
                <div class="footer-top-area ptb-50">
                    <div class="container">
                        <div class="row">
                            <!--Single Footer Start-->
                            <div class="col-lg-4 col-md-6">
                                <div class="single-footer">
                                    <!--Footer Logo Start-->
                                    <div class="footer-logo">
                                        <a href="index.html"><img src="frontend/images/logo5.png" alt></a>
                                    </div>
                                    <!--Footer Logo End-->
                                    <!--Footer Content Start-->
                                    <div class="footer-content">
                                        <div class="contact">
                                            <p><label>Địa chỉ:</label>Kinh Môn-Hải Dương</p>
                                            <p><label>Liên hệ:</label><a href="tel:0381452749"></a>0966541655</p>
                                            <p><label>Email:</label><a href="mailto:dttoan432@gmail.com">tvt28051999@gmail.com</a></p>
                                        </div>
                                    </div>
                                    <!--Footer Content End-->
                                </div>
                            </div>
                            <!--Single Footer End-->
                            <!--Single Footer Start-->
                            <div class="col-lg-2 col-md-6">
                                <div class="single-footer mt-30">
                                    <div class="footer-title">
                                        <h3>Danh mục</h3>
                                    </div>
                                    <ul class="footer-info">
                                        @foreach($menus as $menu)
                                        <li><a href="{{ route('frontend.category', $menu->slug) }}">{{ $menu->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!--Single Footer End-->
                            <!--Single Footer Start-->
                            <div class="col-lg-2 col-md-6">
                                <div class="single-footer mt-30">
                                    <div class="footer-title">
                                        <h3>Tổng đài hỗ trợ</h3>
                                    </div>
                                    <ul class="footer-info">
                                        <li><span>Kỹ thuật: 1800.1763</span></li>
                                        <li><span>Khiếu nại: 1800.1062</span></li>
                                        <li><span>Bảo hành: 1800.1064</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!--Single Footer End-->
                            <!--Single Footer Start-->
                            <style>
                                .footer-title > h3{
                                    text-transform: none;
                                    font-size: 16px;
                                }
                            </style>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-footer mt-30">
                                    <div class="footer-title">
                                        <h3>Theo dõi</h3>
                                    </div>
                                    <ul class="socil-icon mb-40">
                                        <li><a href="https://www.facebook.com/thanvan.tuan.285/" data-toggle="tooltip" title="Facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
                                        <li><a href="" data-toggle="tooltip" title="Skype" target="_blank"><i class="ion-social-skype"></i></a></li>
                                        <li><a href="https://www.youtube.com/channel/UCUzWA2oPQjFEBFOdMuTEbtQ" data-toggle="tooltip" title="Youtube" target="_blank"><i class="ion-social-youtube"></i></a></li>
                                        <li><a href="" data-toggle="tooltip" title="Pinterest" target="_blank"><i class="ion-social-pinterest"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!--Single Footer End-->
                        </div>
                    </div>
                </div>
                <div class="footer-bottom-area">
                    <div class="container">
                        <div class="row">
                            <!--Footer Left Content Start-->
                            <div class="col-lg-6 col-md-6">
                                <div class="copyright-text">
                                    <p>Copyright © <a href="https://www.facebook.com/thanvan.tuan.285/" target="_blank">TuanThan</a>, All Rights Reserved.</p>
                                </div>
                            </div>
                            <!--Footer Left Content End-->
                            <!--Footer Right Content Start-->
                            <div class="col-lg-6 col-md-6">
                                <div class="payment-img text-right">
                                    <span><img src="/frontend/images/payment.png" alt></span>
                                </div>
                            </div>
                            <!--Footer Right Content End-->
                        </div>
                    </div>
                </div>
                <!--Footer Bottom Area End-->
            </div>
        </footer>
        <!--Footer Area End-->
        <!--Modal Start-->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal Content Strat-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="modal-details">
                   <div class="row">
                       <!--Product Img Strat-->
                       <div class="col-xl-5 col-lg-5">
                           <!--Product Tab Content Start-->
                            <div class="tab-content">
                                <div id="watch1" class="tab-pane fade show active">
                                    <div class="modal-img img-full">
                                        <img src="frontend/images/1_1.jpg" alt>
                                    </div>
                                </div>
                                <div id="watch2" class="tab-pane fade">
                                    <div class="modal-img img-full">
                                        <img src="frontend/images/2_7.jpg" alt>
                                    </div>
                                </div>
                                <div id="watch3" class="tab-pane fade">
                                    <div class="modal-img img-full">
                                        <img src="frontend/images/3_3.jpg" alt>
                                    </div>
                                </div>
                                <div id="watch4" class="tab-pane fade">
                                    <div class="modal-img img-full">
                                        <img src="frontend/images/4_4.jpg" alt>
                                    </div>
                                </div>
                                <div id="watch5" class="tab-pane fade">
                                    <div class="modal-img img-full">
                                        <img src="frontend/images/5_2.jpg" alt>
                                    </div>
                                </div>
                                <div id="watch6" class="tab-pane fade">
                                    <div class="modal-img img-full">
                                        <img src="frontend/images/6_2.jpg" alt>
                                    </div>
                                </div>
                            </div>
                            <!--Product Tab Content End-->
                            <!--Single Product Tab Menu Start-->
                            <div class="modal-product-tab">
                                <ul class="nav">
                                    <li><a class="active" data-toggle="tab" href="#watch1"><img src="frontend/images/1_8.jpg" alt></a></li>
                                    <li><a data-toggle="tab" href="#watch2"><img src="frontend/images/3_4.jpg" alt></a></li>
                                    <li><a data-toggle="tab" href="#watch3"><img src="frontend/images/2_6.jpg" alt></a></li>
                                    <li><a data-toggle="tab" href="#watch4"><img src="frontend/images/4_3.jpg" alt></a></li>
                                </ul>
                            </div>
                            <!--Single Product Tab Menu Start-->
                       </div>
                       <!--Product Img End-->
                       <!-- Product Content Start-->
                       <div class="col-xl-7 col-lg-7">
                           <div class="product-info">
                               <h2>Natural passages</h2>
                               <div class="product-price">
                                   <span class="old-price">$74.00</span>
                                   <span class="new-price">$69.00</span>
                               </div>
                               <a href="#" class="see-all">See all features</a>
                               <div class="add-to-cart quantity">
                                    <form class="add-quantity" action="#">
                                         <div class="quantity modal-quantity">
                                             <label>Quantity</label>
                                             <input type="number">
                                         </div>
                                        <div class="add-to-link">
                                            <button class="form-button" data-text="add to cart">add to cart</button>
                                        </div>
                                    </form>
                               </div>
                               <div class="cart-description">
                                   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco,Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus.</p>
                               </div>
                               <div class="social-share">
                                   <h3>Share this product</h3>
                                   <ul class="socil-icon2">
                                       <li><a href><i class="fa fa-facebook"></i></a></li>
                                       <li><a href><i class="fa fa-twitter"></i></a></li>
                                       <li><a href><i class="fa fa-pinterest"></i></a></li>
                                       <li><a href><i class="fa fa-google-plus"></i></a></li>
                                       <li><a href><i class="fa fa-linkedin"></i></a></li>
                                   </ul>
                               </div>
                           </div>
                       </div>
                       <!--Product Content End-->
                   </div>
                </div>
              </div>
            </div>
            <!--Modal Content Strat-->
          </div>
        </div>
