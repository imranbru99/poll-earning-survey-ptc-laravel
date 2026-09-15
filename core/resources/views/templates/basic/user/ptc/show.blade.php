<!doctype html>
<html lang="en">
<h3 style="text-align:center;">Poll Earning News View</h3>

<head>


    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/png" href="{{ asset(imagePath()['logoIcon']['path'] . '/favicon.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


    <!-- bootstrap -->
    @php
        $activeTemplateTrue = activeTemplate(true);
    @endphp
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/bootstrap.min.css') }}">
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <title>{{ $general->sitename(__($page_title) ?? '') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <script type="text/javascript">
        // noprotect

        var statusWindow = document.getElementById('status');

        (function($, win) {
            "use strict";
            //Private variables
            var _LOCALSTORAGE_KEY = 'WINDOW_VALIDATION';
            var RECHECK_WINDOW_DELAY_MS = 1;
            var _initialized = false;
            var _isMainWindow = false;
            var _unloaded = false;
            var _windowArray;
            var _windowId;
            var _isNewWindowPromotedToMain = false;
            var _onWindowUpdated;


            function WindowStateManager(isNewWindowPromotedToMain, onWindowUpdated) {
                //this.resetWindows();
                _onWindowUpdated = onWindowUpdated;
                _isNewWindowPromotedToMain = isNewWindowPromotedToMain;
                _windowId = Date.now().toString();

                bindUnload();

                determineWindowState.call(this);

                _initialized = true;

                _onWindowUpdated.call(this);
            }

            //Determine the state of the window
            //If its a main or child window
            function determineWindowState() {
                var self = this;
                var _previousState = _isMainWindow;

                _windowArray = localStorage.getItem(_LOCALSTORAGE_KEY);

                if (_windowArray === null || _windowArray === "NaN") {
                    _windowArray = [];
                } else {
                    _windowArray = JSON.parse(_windowArray);
                }

                if (_initialized) {
                    //Determine if this window should be promoted
                    if (_windowArray.length <= 1 ||
                        (_isNewWindowPromotedToMain ? _windowArray[_windowArray.length - 1] : _windowArray[0]) ===
                        _windowId) {
                        _isMainWindow = true;
                    } else {
                        _isMainWindow = false;
                    }
                } else {
                    if (_windowArray.length === 0) {
                        _isMainWindow = true;
                        _windowArray[0] = _windowId;
                        localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
                    } else {
                        _isMainWindow = false;
                        _windowArray.push(_windowId);
                        localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
                    }
                }

                //If the window state has been updated invoke callback
                if (_previousState !== _isMainWindow) {
                    _onWindowUpdated.call(this);
                }

                //Perform a recheck of the window on a delay
                setTimeout(function() {
                    determineWindowState.call(self);
                }, RECHECK_WINDOW_DELAY_MS);
            }

            //Remove the window from the global count
            function removeWindow() {
                var __windowArray = JSON.parse(localStorage.getItem(_LOCALSTORAGE_KEY));
                for (var i = 0, length = __windowArray.length; i < length; i++) {
                    if (__windowArray[i] === _windowId) {
                        __windowArray.splice(i, 1);
                        break;
                    }
                }
                //Update the local storage with the new array
                localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(__windowArray));
            }

            //Bind unloading events
            function bindUnload() {
                win.addEventListener('beforeunload', function() {
                    if (!_unloaded) {
                        removeWindow();
                    }
                });
                win.addEventListener('unload', function() {
                    if (!_unloaded) {
                        removeWindow();
                    }
                });
            }

            WindowStateManager.prototype.isMainWindow = function() {
                return _isMainWindow;
            };

            WindowStateManager.prototype.resetWindows = function() {
                localStorage.removeItem(_LOCALSTORAGE_KEY);
            };

            win.WindowStateManager = WindowStateManager;
        })(jQuery, window);

        var WindowStateManager = new WindowStateManager(false, windowUpdated);

        function windowUpdated() {
            if (this.isMainWindow() == false) {
                window.close();
            }
        }
        //Resets the count in case something goes wrong in code
        //WindowStateManager.resetWindows()
    </script>
    <style>
        #myProgress {
            width: 100%;
            background-color: #ddd;
        }

        #myBar {
            width: 10%;
            height: 30px;
            background-color: #470028;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        #confirm {
            color: white;
            font-weight: 600;
        }

        .inputcaptcha {
            width: 60px;
        }

        .btn {
            margin-top: -4px;
        }

        @media (max-width: 767px) {
            ul.nav.navbar-nav.navbar-right {
                margin-top: 15px;
            }

            .container {
                display: flex !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 320px) {
            .row {
                display: flex;
                justify-content: center;
            }

            .btn {
                margin-top: 5px;

            }
        }

        .adFram {
            border: 0;
            position: absolute;
            top: 75%;
            left: 0;
            right: 0;
            bottom: 40;
            width: 100%;
            height: 100%
        }

        .adBody {
            position: absolute;
            top: 30%;
            left: 10%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-danger bg-primary p-4">
        <div class="container">
            <div class="col-md-4">
                <div id="myProgress">
                    <div id="myBar">0%</div>
                </div>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="active row">
                    <span id="inputcaptchahidden" class="d-none">
                        <input name="num1" id="cap_number_1" class="inputcaptcha" value="{{ rand(0, 9) }}"
                            type="text" readonly>
                        <label for="exampleInputEmail2 text-white"> + </label>
                        <input name="num2" id="cap_number_2" class="inputcaptcha" value="{{ rand(11, 19) }}"
                            type="text" readonly>
                        <label for="exampleInputEmail2 text-white">=</label>
                        <input name="result" type="number" class="inputcaptcha" id="cap_result" required>&nbsp;
                    </span>
                    <a type="button" id="confirm" class="btn btn-danger btn-md" disabled>
                        @lang('Loading Ads')
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <script>
        (function($, document) {
            "use strict";
            $('#cap_result').on('input', function() {

                var val1 = document.getElementById("cap_number_1").value;
                var val2 = document.getElementById("cap_number_2").value;
                var val3 = document.getElementById("cap_result").value;
                var sum = parseInt(+val1 + +val2);
                if (sum == val3) {
                    var confirmButton = document.getElementById("confirm");
                    confirmButton.removeAttribute('disabled');
                    confirmButton.className = "btn btn-success";
                    confirmButton.setAttribute('href',
                        '{{ route('user.ptc.confirm', Crypt::encryptString($ptc->id . '|' . auth()->user()->id)) }}'
                        );
                } else {
                    var confirmButton = document.getElementById("confirm");
                    confirmButton.setAttribute('disabled', '');
                    confirmButton.className = "btn btn-danger";
                    confirmButton.removeAttribute('href', '#');
                }
            });

            function move() {
                var elem = document.getElementById("myBar");
                var width = 0;
                var id = setInterval(frame, {{ $ptc->duration * 10 }});

                function frame() {
                    if (width >= 100) {
                        var confirmButton = document.getElementById("confirm");
                        confirmButton.className = "btn btn-danger";
                        confirmButton.innerHTML = "Confirm";
                        var captchaInputHidden = document.getElementById("inputcaptchahidden");
                        captchaInputHidden.classList.remove("d-none");
                        clearInterval(id);
                    } else {
                        width++;
                        elem.style.width = width + '%';
                        elem.innerHTML = width + '%';
                    }
                }
            }
            window.onload = move;
        })(jQuery, document);



        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                document.body.innerHTML = `
                               <div class="d-flex flex-wrap justify-content-center align-items-center clear-msg">
                                    <h3 class="text-danger text-center">@lang('Sorry, You can\'t go anywhere from Trade fou ADS tab while viewing an Ads')</h3>
                                </div>
                            `;
            }
        });
    </script>


    <div class="row">
        @if ($ptc->ads_type == 1)
            <iframe src="{{ $ptc->ads_body }}" class="adFram"></iframe>
        @elseif($ptc->ads_type == 2)
            <div class="container mt-5">
                <img src="{{ asset('assets/images/ptcimages/' . $ptc->ads_body) }}" class="w-100">
            </div>
        @else
            <div class="adBody">
                @php echo $ptc->ads_body @endphp
            </div>
        @endif

    </div>
    <script src="{{ asset($activeTemplateTrue . '/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
