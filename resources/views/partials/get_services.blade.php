 <label class="required">@lang('Services')</label>

                        <div class="service-wrapper">
                            <div class="first-service-wrapper">
                                <div class="d-flex service-item position-relative mb-3 flex-wrap">
                                        
                                     @foreach ($extraServices as $extraService)
                                     
                                            <div  style="display: flex;align-items: center; ">
                                            <label style="margin-right: 10px;" >&nbsp; @lang('Qty')</label>
                                            <input style="width: 15%; height:30px; margin-bottom:3px; float:right; margin-right:10px;" type="text" placeholder="@lang('Quantity')" value="1" name="qty[]">
                                            <input type="checkbox" style="width: 20px !important;  height: 20px !important; margin-bottom: revert;" id="checkbox{{ $extraService->id }}" value="{{ $extraService->id }}" name="services[]" checked >
                                            <label for="checkbox{{ $extraService->id }}" style=" margin-left: 10px; font-size:15px">{{ __($extraService->name) }}</label>
                                            <!--<label for="checkbox{{ $extraService->id }}" style=" margin-right: 10px;">{{ __($extraService->name) }} - {{ $general->cur_sym . showAmount($extraService->cost) }}/@lang('piece')  :</label>-->
                                           
                                            
                                            </div>
                             
                                         @endforeach
                                      
                                </div>
                            </div>
                        </div>

                     
                        
                        
                        
       