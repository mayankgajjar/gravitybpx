<div class="main-dialer">
    <div class="dialer-call-wrapper">
        <div class="dialer-dis dialer-icon">
            <a href="javascript:;" class="dialer_ic" onclick="diaplayCallDiv('zoomIn')">
                <img src="<?php echo site_url() ?>assets/images/dialer.svg" alt="dialer_icon"/>
            </a>
        </div>
        <div class="call-field">
            <div id="call-field" class="phone-dialer dialer1" style="diaply: none;">
                <div class="call-out">
                    <div class="call-out-icon">
                        <a id="callBtn" href="javascript:;" onclick="javascript:call();">
                            <img src="<?php echo site_url() ?>assets/images/call-out.svg" alt="dialer_icon"/>
                        </a>
                    </div>
                </div>
                <div class="dialer-input-div">
                    <input type="text" id="phone_num" name="phone_num"  class="form-control" placeholder="Phone Number..."/>
                </div>
                <div class="msg-bubbles">
                    <div class="msg-bubbles-icon">
                        <a href="javascript:;" onclick="diaplayTextDiv('zoomIn')">
                            <img src="<?php echo site_url() ?>assets/images/bubbles.svg" alt="dialer_icon"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .dialer-call-wrapper -->
    <div class="dialer-box-wrapper" id="dialer-box" style="display: none;">
        <div class="toggle-icon-bar">
            <a href="javascript:;" onclick="minimizeDiv('dialer_screen', 'dialer-box')">
                <img class="toggle-icon" src="<?php echo site_url() ?>assets/images/toggle-icon.png"/>
            </a>
        </div>
        <div class="dialer_screen">
            <div class="dialer_header">
                <div class="profile">
                    <div class="profile-image">
                        <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image" />
                    </div>
                </div>
                <div class="profile-content">
                        <h4 class="leadname">John Smith</h4>
                        <p class="leadtype">Client</p>
                </div>
                <div class="btn-min">
                    <a href="javascript:;" onclick="minimizeDiv('dialer_screen', this)"><img src="<?php echo site_url() ?>assets/images/min.png"/></a>
                    <a href="javascript:;" onclick="closeDialPad()"><img src="<?php echo site_url() ?>assets/images/close-icon.png"/></a>
                </div>
            </div>
            <div class="dialer_body">
                <div class="dialer_btn">
                    <div class="dialer-btn-container">
                        <div class="dialer-btnss">
                            <a class="btn btn-info" href="#">1</a>
                            <a class="btn btn-info" href="javascript:void(0)">2<span>abc</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">3<span>def</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">4<span>ghi</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">5<span>jkl</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">6<span>mno</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">7<span>pqrs</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">8<span>tuv</span></a>
                            <a class="btn btn-info" href="javascript:void(0)">9<span>wxyz</span></a>
                            <a class="btn btn-info" href="javascript:;">*</a>
                            <a class="btn btn-info" href="javascript:;">0</a>
                            <a class="btn btn-info" href="javascript:;">#</a>
                        </div>
                        <div class="dialer-call-actions">
                            <ul>
                                <li>
                                    <a href="javascript:;">
                                        <img src="<?php echo site_url() ?>assets/images/transfer.png" alt="transfer" />
                                        <span>Transfer</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="<?php echo site_url() ?>assets/images/hold.png" alt="hold" />
                                        <span>hold</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="<?php echo site_url() ?>assets/images/mute.png" alt="mute" />
                                        <span>Mute</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="leadPop('zoomIn');">
                                        <img src="<?php echo site_url() ?>assets/images/record.png" alt="record" />
                                        <span>Record</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dialer_footer">
                <div class="call-ui-wrapper">
                    <div class="call-ui-footer phone-dialer dialer2">
                        <div class="call-out">
                            <div class="call-out-icon">
                                <a href="javascript:;" title="Hangup"  onclick="hangup()">
                                    <img style="transform: rotate(190deg)" id="dpad-call-out" src="<?php echo site_url() ?>assets/images/call-out.svg" alt="dialer_icon"/>
                                </a>
                            </div>
                        </div>
                        <div class="dialer-input-div">
                            <input type="text"  class="form-control" placeholder="Phone Number..." id="dpad-phone" name="dpad-phone"/>
                        </div>
                        <div class="msg-bubbles">
                            <div class="msg-bubbles-icon">
                                <a href="javascript:;">
                                    <img src="<?php echo site_url() ?>assets/images/bubbles.svg" alt="dialer_icon"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- lead view -->
            <div class="profile-popup-wrapper" id="lead-view">
                <div class="toggle-icon-bar">
                    <a href="javascript:;" onclick="minimizeDiv('popup-screen', 'lead-view')">
                        <img class="toggle-icon" src="<?php echo site_url() ?>assets/images/toggle-icon.png">
                    </a>
                </div>
                <div class="popup-screen">
                    <form id="lead-pop-form" method="post" onsubmit="saveLead(event);return false;">
                    <div class="dialer_header">
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                            </div>
                        </div>
                        <div class="profile-content">
                            <h4 class="leadname1">&nbsp;</h4>
                            <p class="leadtype">&nbsp;</p>
                        </div>
                        <div class="btn-min">
                            <a href="javascript:;"><img src="<?php echo site_url() ?>assets/images/min.png"/></a>
                            <a href="javascript:;" onclick="leadPop();"><img src="<?php echo site_url() ?>assets/images/close-icon.png"/></a>
                        </div>
                    </div>
                    <div class="dialer_body">
                        <div class="dialer-form">
                                <input type="hidden" name="called_count" id="called_count" />
                                <input type="hidden" name="CallUUID" id="CallUUID"/>
                                <input type="hidden" name="lead_id" id="lead_id"/>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" id="cellno" id="cellno" name="cellno"/>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email"/>
                                </div>
                                <div class="detail_address">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit,app...</label>
                                        <input type="text" class="form-control" id="app" name="app"/>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" id="city" name="city"/>
                                    </div>
                                    <div class="form-group">
                                        <?php $states = $this->db->get('state')->result(); ?>
                                        <label>State</label>
                                        <select class="form-control" id="state" name="state" style="width: 55%;">
                                            <option value=""></option>
                                                <?php foreach($states as $state): ?>
                                                <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>"><?php echo $state->name ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Zip</label>
                                    <input type="text" class="form-control" id="zip" name="zip"/>
                                </div>
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea class="form-control" id="notes" name="notes"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn-default" type="submit">Save</button>
                                </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- lead view -->
        </div>
    </div>
    <div class="dialer-chatbox-wrapper" id="dialer-chatbox" style="display: none;">
        <div class="chatbox-screen">
            <div class="dialer_header">
                <div class="profile">
                    <div class="profile-image">
                        <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                    </div>
                </div>
                <div class="profile-content">
                    <h4 class="leadname">&nbsp;</h4>
                    <p class="leadtype">&nbsp;</p>
                </div>
                <div class="btn-min">
                    <a href="javascript:;" onclick="minimizeDiv('chatbox-screen', this)"><img src="<?php echo site_url() ?>assets/images/min.png"/></a>
                    <a href="javascript:;" onclick="diaplayTextDiv('zoomOut')"><img src="<?php echo site_url() ?>assets/images/close-icon.png"/></a>
                </div>
            </div>
            <div class="dialer_body">
                <div class="chat-box">
                    <ul class="chat_ul">
                        <li class="left-msg">
                            <div class="chat-profile-img">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                            <div class="chat-content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                        </li>
                        <li class="right-msg">
                            <div class="chat-content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                            <div class="chat-profile-img">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                        </li>
                        <li class="left-msg">
                            <div class="chat-profile-img">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                            <div class="chat-content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                        </li>
                        <li class="right-msg">
                            <div class="chat-content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                            <div class="chat-profile-img">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                        </li>
                        <li class="left-msg">
                            <div class="chat-profile-img">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                            <div class="chat-content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                        </li>
                        <li class="left-msg">
                            <div class="chat-profile-img">
                                <div class="profile-image">
                                    <img src="<?php echo site_url() ?>assets/images/Avatar.png" alt="user_image">
                                </div>
                            </div>
                            <div class="chat-content">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                            </div>
                        </li>
                    </ul>
                    <div class="msg_type_input">
                        <input type="text" class="form-control" placeholder="Type text here to be sent to client"/>
                        <a href="javascript:;" class="send-btn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="dialer_footer">
                <div class="call-ui-wrapper">
                    <div class="call-ui-footer phone-dialer dialer3">
                        <div class="call-out">
                            <div class="call-out-icon">
                                <a href="javascript:;">
                                    <img src="<?php echo site_url() ?>assets/images/call-out.svg" alt="dialer_icon">
                                </a>
                            </div>
                        </div>
                        <div class="dialer-input-div">
                            <input type="text" class="form-control" placeholder="Phone Number...">
                        </div>
                        <div class="msg-bubbles">
                            <div class="msg-bubbles-icon">
                                <a href="javascript:;">
                                    <img src="<?php echo site_url() ?>assets/images/bubbles.svg" alt="dialer_icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>