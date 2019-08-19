var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var __values = (this && this.__values) || function (o) {
    var m = typeof Symbol === "function" && o[Symbol.iterator], i = 0;
    if (m) return m.call(o);
    return {
        next: function () {
            if (o && i >= o.length) o = void 0;
            return { value: o && o[i++], done: !o };
        }
    };
};
/**
 * Handle Ajax Requests
 */
var Ajax = /** @class */ (function () {
    function Ajax(url, method, data, headers) {
        if (method === void 0) { method = 'get'; }
        if (data === void 0) { data = {}; }
        if (headers === void 0) { headers = []; }
        /**
         * add all headers into array and set it
         *
         * @private
         * @type {Array<Header>}
         * @memberof Ajax
         */
        this._headers = [];
        this._url = url;
        this._method = method.toUpperCase();
        this.postData = data;
        this._headers = headers;
        this.xhttp = new XMLHttpRequest;
    }
    /**
     * add new header for that instance
     *
     * @param {string} key
     * @param {string} value
     * @memberof Ajax
     */
    Ajax.prototype.addHeader = function (key, value) {
        this._headers.push({
            key: key,
            value: value
        });
    };
    /**
     * add data for post request
     *
     * @param {string} key
     * @param {*} value
     * @memberof Ajax
     */
    Ajax.prototype.addData = function (key, value) {
        this.postData = {
            key: value,
            val: 'asd'
        };
    };
    /**
     * send the request and retriving the data from server as string
     *
     * @returns {Promise<string>}
     * @memberof Ajax
     */
    Ajax.prototype.send = function () {
        return __awaiter(this, void 0, void 0, function () {
            var dataUrl;
            var _this = this;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0: return [4 /*yield*/, this.getData()];
                    case 1:
                        dataUrl = _a.sent();
                        // open the request before setting the headers
                        this.xhttp.open(this._method, this._url, true);
                        // attach all headers to this request
                        return [4 /*yield*/, this.setHeaders()];
                    case 2:
                        // attach all headers to this request
                        _a.sent();
                        return [2 /*return*/, new Promise(function (res, rej) {
                                _this.xhttp.onreadystatechange = function () {
                                    // if connection has done
                                    if (this.readyState === XMLHttpRequest.DONE) {
                                        // check if statusCode is 200 resolve success
                                        if (this.status === 200)
                                            res(this.response);
                                        else
                                            rej(this.status); // show error
                                    }
                                };
                                // if the timeout has passed show error with timeout
                                _this.xhttp.ontimeout = function () {
                                    rej('timeout');
                                };
                                // send the request with data
                                _this.xhttp.send(dataUrl);
                            })];
                }
            });
        });
    };
    /**
     * set the http headers
     *
     * @private
     * @returns {Promise<boolean>}
     * @memberof Ajax
     */
    Ajax.prototype.setHeaders = function () {
        return __awaiter(this, void 0, void 0, function () {
            var e_1, _a, _b, _c, h;
            return __generator(this, function (_d) {
                try {
                    for (_b = __values(this._headers), _c = _b.next(); !_c.done; _c = _b.next()) {
                        h = _c.value;
                        this.xhttp.setRequestHeader(h.key, h.value);
                    }
                }
                catch (e_1_1) { e_1 = { error: e_1_1 }; }
                finally {
                    try {
                        if (_c && !_c.done && (_a = _b.return)) _a.call(_b);
                    }
                    finally { if (e_1) throw e_1.error; }
                }
                return [2 /*return*/, true];
            });
        });
    };
    /**
     * turn data object{key: value} into url query params
     *
     * @private
     * @returns {Promise<string>}
     * @memberof Ajax
     */
    Ajax.prototype.getData = function () {
        return __awaiter(this, void 0, void 0, function () {
            var encoded, prop;
            return __generator(this, function (_a) {
                encoded = '';
                for (prop in this.postData) {
                    if (this.postData.hasOwnProperty(prop)) {
                        if (encoded.length > 0) {
                            encoded += '&';
                        }
                        encoded += encodeURI(prop + '=' + this.postData[prop]);
                    }
                }
                return [2 /*return*/, encoded];
            });
        });
    };
    /**
     * default header for get method
     *
     * @static
     * @type {Header}
     * @memberof Ajax
     *
     * @default
     */
    Ajax.TEXT_HEADER = {
        key: 'Content-Type',
        value: 'text/plain;charset=UTF-8'
    };
    /**
     * default header for post method
     *
     * @static
     * @type {Header}
     * @memberof Ajax
     */
    Ajax.POST_HEADER = {
        key: 'Content-Type',
        value: 'application/x-www-form-urlencoded;charset=UTF-8'
    };
    /**
     * default header for json data type
     *
     * @static
     * @type {Header}
     * @memberof Ajax
     */
    Ajax.JSON_HEADER = {
        key: 'Content-Type',
        value: 'application/json;charset=UTF-8'
    };
    return Ajax;
}());
var El = /** @class */ (function () {
    function El(cssSelector) {
        if (cssSelector instanceof El
            || cssSelector instanceof HTMLElement) {
            this.el = cssSelector;
        }
        else {
            this.cssSelector = cssSelector;
            this.el = document.querySelector(this.cssSelector);
        }
    }
    El.prototype.getAll = function () {
        return document.querySelectorAll(this.cssSelector);
    };
    El.prototype.handleAll = function (callback) {
        // get the list of html elemnts with that selector
        var elArr = this.getAll();
        // loop through elements
        for (var i in elArr) {
            // run the callback function with the current element
            if (elArr.hasOwnProperty(i)) {
                callback(elArr[i]);
            }
        }
    };
    El.prototype.getId = function () {
        return this.el.id;
    };
    El.prototype.addClass = function (cls) {
        if (this.el.className.indexOf(cls) === -1) {
            this.el.className += ' ' + cls;
        }
    };
    El.prototype.removeClass = function (cls) {
        this.el.className = this.el.className.replace(cls, '');
    };
    El.prototype.css = function (prop, value) {
        this.el.style[prop] = value;
    };
    El.prototype.attr = function (prop, value) {
        if (value === void 0) { value = null; }
        // check if no value added then return current attribute value
        if (null === value)
            return this.el.getAttribute(prop);
        // set attribute value
        this.el.setAttribute(prop, value);
    };
    El.prototype.focus = function (callback) {
        this.addEvent('focus', callback);
    };
    El.prototype.blur = function (callback) {
        this.addEvent('blur', callback);
    };
    El.prototype.keyPress = function (callback) {
        this.addEvent('keypress', callback);
    };
    El.prototype.on = function (ev, callback) {
        var e_2, _a;
        var evs = ev.split(' ');
        if (evs.length > 1) {
            try {
                for (var evs_1 = __values(evs), evs_1_1 = evs_1.next(); !evs_1_1.done; evs_1_1 = evs_1.next()) {
                    var e = evs_1_1.value;
                    this.addEvent(e, callback);
                }
            }
            catch (e_2_1) { e_2 = { error: e_2_1 }; }
            finally {
                try {
                    if (evs_1_1 && !evs_1_1.done && (_a = evs_1.return)) _a.call(evs_1);
                }
                finally { if (e_2) throw e_2.error; }
            }
        }
        else {
            this.addEvent(ev, callback);
        }
    };
    El.prototype.val = function (value) {
        if (value === void 0) { value = null; }
        if (null === value) {
            return this.el.value;
        }
        this.el.value = value;
    };
    El.prototype.parent = function () {
        return new El(this.el.parentElement);
    };
    El.prototype.isActive = function () {
        return (document.activeElement === this.el);
    };
    El.prototype.addEvent = function (event, callback) {
        this.el.addEventListener(event, function (ev) {
            callback(ev);
        }, true);
    };
    return El;
}());
/**
 * factory to create El instance
 *
 * @param {*} cssSelector
 * @returns
 */
function $(cssSelector) {
    return (new El(cssSelector));
}
var App = /** @class */ (function () {
    function App() {
    }
    App.prototype.run = function () {
        $('button').on('click', function (ev) {
            console.log(ev, ev.target.id);
        });
    };
    return App;
}());
(new App()).run();
$('#showPass').on('click', function (ev) {
    var self = $(ev.target);
    if (ev.target.className.indexOf('active') > -1) {
        self.removeClass('btn-danger');
        self.removeClass('active');
        $('.password').handleAll(function (el) {
            $(el).attr('type', 'password');
        });
    }
    else {
        self.addClass('btn-danger');
        self.addClass('active');
        $('.password').handleAll(function (el) {
            $(el).attr('type', 'text');
        });
    }
});
$('form.needs-validation').handleAll(function (el) {
    $(el).on('submit', function (ev) {
        var self = ev.target;
        var isNotValid = (self.checkValidity() === false), passMatch = ($('#password').val() !== $('#confPassword').val());
        if (isNotValid || passMatch) {
            ev.preventDefault();
            ev.stopPropagation();
            if (passMatch) {
                $('#password').addClass('is-invalid');
            }
        }
        $('.submit').addClass('loading');
        $(self).addClass('was-validated');
    });
});
//# sourceMappingURL=app.js.map