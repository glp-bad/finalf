(function (t) {
    function e(e) {
        for (var n, o, r = e[0], c = e[1], l = e[2], u = 0, h = []; u < r.length; u++) o = r[u], Object.prototype.hasOwnProperty.call(a, o) && a[o] && h.push(a[o][0]), a[o] = 0;
        for (n in c) Object.prototype.hasOwnProperty.call(c, n) && (t[n] = c[n]);
        d && d(e);
        while (h.length) h.shift()();
        return s.push.apply(s, l || []), i()
    }

    function i() {
        for (var t, e = 0; e < s.length; e++) {
            for (var i = s[e], n = !0, r = 1; r < i.length; r++) {
                var c = i[r];
                0 !== a[c] && (n = !1)
            }
            n && (s.splice(e--, 1), t = o(o.s = i[0]))
        }
        return t
    }

    var n = {}, a = {app: 0}, s = [];

    function o(e) {
        if (n[e]) return n[e].exports;
        var i = n[e] = {i: e, l: !1, exports: {}};
        return t[e].call(i.exports, i, i.exports, o), i.l = !0, i.exports
    }

    o.m = t, o.c = n, o.d = function (t, e, i) {
        o.o(t, e) || Object.defineProperty(t, e, {enumerable: !0, get: i})
    }, o.r = function (t) {
        "undefined" !== typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(t, "__esModule", {value: !0})
    }, o.t = function (t, e) {
        if (1 & e && (t = o(t)), 8 & e) return t;
        if (4 & e && "object" === typeof t && t && t.__esModule) return t;
        var i = Object.create(null);
        if (o.r(i), Object.defineProperty(i, "default", {
            enumerable: !0,
            value: t
        }), 2 & e && "string" != typeof t) for (var n in t) o.d(i, n, function (e) {
            return t[e]
        }.bind(null, n));
        return i
    }, o.n = function (t) {
        var e = t && t.__esModule ? function () {
            return t["default"]
        } : function () {
            return t
        };
        return o.d(e, "a", e), e
    }, o.o = function (t, e) {
        return Object.prototype.hasOwnProperty.call(t, e)
    }, o.p = "/";
    var r = window["webpackJsonp"] = window["webpackJsonp"] || [], c = r.push.bind(r);
    r.push = e, r = r.slice();
    for (var l = 0; l < r.length; l++) e(r[l]);
    var d = c;
    s.push([0, "chunk-vendors"]), i()
})({
    0: function (t, e, i) {
        t.exports = i("56d7")
    }, "4d20": function (t, e, i) {
        t.exports = i.p + "img/apps_blue.svg"
    }, "56d7": function (t, e, i) {
        "use strict";
        i.r(e);
        i("e260"), i("e6cf"), i("cca6"), i("a79d");
        var n = i("7a23");

        function a(t, e, i, a, s, o) {
            var r = Object(n["z"])("my-login"), c = Object(n["z"])("menu-main"), l = Object(n["z"])("router-view");
            return Object(n["t"])(), Object(n["f"])(n["a"], null, [this.login ? Object(n["e"])("", !0) : (Object(n["t"])(), Object(n["d"])(r, {
                key: 0,
                ref: "refLogin",
                onLoginWindows: o.emitLogin
            }, null, 8, ["onLoginWindows"])), this.login ? (Object(n["t"])(), Object(n["d"])(c, {
                ref: "refMenuLogout",
                onLogoutMenuMain: o.emitMenuLogout,
                key: this.engine.keyRender
            }, null, 8, ["onLogoutMenuMain"])) : Object(n["e"])("", !0), Object(n["i"])(l)], 64)
        }

        var s = {class: "ff-navbar"}, o = Object(n["h"])("Gridul"), r = Object(n["h"])("Test controale"),
            c = Object(n["g"])("a", {href: "javascript:void(null);"}, "Logout", -1), l = [c],
            d = Object(n["g"])("li", {class: "li-right"}, [Object(n["g"])("a", {href: "#about"}, "About")], -1);

        function u(t, e, i, a, c, u) {
            var h = Object(n["z"])("router-link");
            return Object(n["t"])(), Object(n["f"])("div", s, [Object(n["g"])("ul", null, [Object(n["g"])("li", null, [Object(n["i"])(h, {to: "/viewGridul"}, {
                default: Object(n["G"])((function () {
                    return [o]
                })), _: 1
            })]), Object(n["g"])("li", null, [Object(n["i"])(h, {to: "/testControale"}, {
                default: Object(n["G"])((function () {
                    return [r]
                })), _: 1
            })]), Object(n["g"])("li", {
                class: "li-right", onClick: e[0] || (e[0] = function () {
                    return u.mLogout && u.mLogout.apply(u, arguments)
                })
            }, l), d])])
        }

        var h = {
            name: "menu-main", created: function () {
                this.URI_LOGOUT = this.$url.getUrl("logout"), this.EMIT = "logoutMenuMain"
            }, methods: {
                mLogout: function () {
                    var t = this;
                    this.axios.post(this.URI_LOGOUT).then((function (e) {
                        e.data.succes ? t.logout = !0 : t.logout = !1, t.$emit(t.EMIT)
                    }))
                }, isLogout: function () {
                    return this.logout
                }
            }, data: function () {
                return {logout: !1}
            }
        }, f = i("6b0d"), g = i.n(f);
        const b = g()(h, [["render", u]]);
        var p = b, O = {class: "w-login-modal"}, m = {class: "w-login", ref: "windowRef"},
            v = {class: "header", ref: "headerRef"}, E = Object(n["g"])("span", null, "Login", -1), j = [E],
            R = {class: "content"}, C = {class: "ff-form-table"},
            y = Object(n["g"])("td", {class: "label-left bold"}, [Object(n["g"])("label", {for: "email"}, "E-Mail Address")], -1),
            w = {class: "control"},
            T = Object(n["g"])("td", {class: "label-left bold"}, [Object(n["g"])("label", {for: "password"}, "Password")], -1),
            _ = {class: "control"}, D = {colspan: "2"}, N = Object(n["g"])("br", null, null, -1),
            A = Object(n["g"])("label", {for: "remember", class: "label-left bold"}, " Remember Me ", -1),
            S = Object(n["g"])("br", null, null, -1), L = Object(n["h"])("Login"), I = {key: 0, class: "red-label"},
            F = Object(n["g"])("div", {class: "bottom-line"}, null, -1);

        function $(t, e, i, a, s, o) {
            var r = Object(n["z"])("my-button");
            return Object(n["t"])(), Object(n["f"])("div", O, [Object(n["g"])("div", m, [Object(n["g"])("div", v, j, 512), Object(n["g"])("div", R, [Object(n["g"])("form", {
                onSubmit: e[3] || (e[3] = Object(n["I"])((function () {
                    return o.logOn && o.logOn.apply(o, arguments)
                }), ["prevent"]))
            }, [Object(n["g"])("table", C, [Object(n["g"])("tr", null, [y, Object(n["g"])("td", w, [Object(n["H"])(Object(n["g"])("input", {
                id: "email",
                type: "email",
                size: "30",
                name: "email",
                required: "",
                autocomplete: "email",
                autofocus: "",
                "onUpdate:modelValue": e[0] || (e[0] = function (t) {
                    return s.post.email = t
                })
            }, null, 512), [[n["E"], s.post.email]])])]), Object(n["g"])("tr", null, [T, Object(n["g"])("td", _, [Object(n["H"])(Object(n["g"])("input", {
                id: "password",
                type: "password",
                size: "30",
                name: "password",
                required: "",
                autocomplete: "current-password",
                "onUpdate:modelValue": e[1] || (e[1] = function (t) {
                    return s.post.password = t
                })
            }, null, 512), [[n["E"], s.post.password]])])]), Object(n["g"])("tr", null, [Object(n["g"])("td", D, [N, Object(n["H"])(Object(n["g"])("input", {
                type: "checkbox",
                name: "remember",
                id: "remember",
                "onUpdate:modelValue": e[2] || (e[2] = function (t) {
                    return s.post.remember = t
                })
            }, null, 512), [[n["D"], s.post.remember]]), A])])]), S, Object(n["g"])("div", null, [Object(n["g"])("div", null, [Object(n["i"])(r, {type: t.submit}, {
                default: Object(n["G"])((function () {
                    return [L]
                })), _: 1
            }, 8, ["type"]), this.requestLoginFail ? (Object(n["t"])(), Object(n["f"])("span", I, Object(n["B"])(this.messageFail), 1)) : Object(n["e"])("", !0)])])], 32)]), F], 512)])
        }

        var k = ["title"], B = Object(n["h"])("Button");

        function M(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("button", {
                class: Object(n["o"])(this.getClassButton()),
                title: this.title
            }, [Object(n["y"])(t.$slots, "default", {}, (function () {
                return [B]
            }))], 10, k)
        }

        i("a9e3");
        var P = {
            name: "my-button",
            props: {
                widthButton: {type: Number, default: 0},
                heightButton: {type: Number, default: 25},
                buttonType: {type: Number, default: 0},
                title: {type: String, default: "button"}
            },
            created: function () {
                this.CLASS_DISABLE = "disable", this.CLASS_PERMANENT_OVER = "ff-button-selected"
            },
            mounted: function () {
                this.widthButton > 0 && (this.$el.style.width = this.widthButton + "px"), this.$el.style.height = this.heightButton + "px"
            },
            methods: {
                disable: function (t) {
                    t ? (this.$el.setAttribute("disabled", !0), this.$el.classList.add(this.CLASS_DISABLE)) : (this.$el.removeAttribute("disabled"), this.$el.classList.remove(this.CLASS_DISABLE))
                }, permanentOver: function (t) {
                    t ? this.$el.classList.add(this.CLASS_PERMANENT_OVER) : this.$el.classList.remove(this.CLASS_PERMANENT_OVER)
                }, getClassButton: function () {
                    var t = "ff-button";
                    return 1 == this.buttonType ? t += "-icon" : 2 == this.buttonType && (t += "-icon-toolbar"), t
                }
            }
        };
        const x = g()(P, [["render", M]]);
        var G = x, U = {
            name: "my-login", components: {"my-button": G}, props: {}, created: function () {
                this.EMIT = "loginWindows", this.URI = this.$url.getUrl("login")
            }, mounted: function () {
                this.post = {
                    email: "gavrilapaul@hotmail.com",
                    password: null
                }, this.$vanilla.dragDiv(this.$refs.windowRef, this.$refs.headerRef)
            }, methods: {
                logOn: function () {
                    var t = this;
                    console.log("this.URI: ", this.URI), this.axios.post(this.URI, this.post).then((function (e) {
                        e.data.succes ? (t.login = !0, t.requestLoginFail = !1) : t.privateSetLoginFail("Incorrect credentials. Try again."), t.$emit(t.EMIT)
                    })).catch((function (e) {
                        t.privateSetLoginFail("Refresh page and try again."), t.$emit(t.EMIT)
                    }))
                }, isLogOn: function () {
                    return this.login
                }, privateSetLoginFail: function (t) {
                    this.login = !1, this.requestLoginFail = !0, this.messageFail = t
                }
            }, data: function () {
                return {post: {}, login: !1, requestLoginFail: !1, messageFail: "Login fail."}
            }
        };
        const H = g()(U, [["render", $]]);
        var z = H, W = {
            components: {"menu-main": p, "my-login": z}, methods: {
                emitLogin: function () {
                    this.engine.keyRender++, this.login = this.$refs.refLogin.isLogOn(), this.$router.push("/")
                }, emitMenuLogout: function () {
                    this.$refs.refMenuLogout.isLogout() && (this.engine.keyRender++, this.login = !1)
                }
            }, data: function () {
                return {login: !1, engine: {keyRender: 1}}
            }
        };
        i("a01e");
        const V = g()(W, [["render", a]]);
        var Y = V, K = i("6c02");

        function q(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("div")
        }

        var Q = {name: "Home", components: {}};
        const Z = g()(Q, [["render", q]]);
        var X = Z, J = Object(n["h"])("Test de click pe butonul meu"), tt = Object(n["g"])("br", null, null, -1),
            et = Object(n["g"])("br", null, null, -1), it = Object(n["h"])("windows warnning"),
            nt = Object(n["h"])("  "), at = Object(n["h"])("windows yesno"), st = Object(n["h"])("  "),
            ot = Object(n["h"])("windows info"), rt = Object(n["h"])("  "), ct = Object(n["h"])("windows redAlert"),
            lt = Object(n["h"])("  "), dt = Object(n["h"])("windows check"), ut = Object(n["h"])("  "),
            ht = Object(n["h"])("windows red-skull"), ft = Object(n["h"])("  "), gt = Object(n["h"])("Formular"),
            bt = Object(n["h"])("  "), pt = Object(n["h"])("  "), Ot = Object(n["g"])("br", null, null, -1),
            mt = Object(n["g"])("br", null, null, -1), vt = Object(n["h"])("Text......."), Et = Object(n["h"])("  "),
            jt = Object(n["g"])("br", null, null, -1), Rt = Object(n["g"])("br", null, null, -1),
            Ct = Object(n["g"])("br", null, null, -1), yt = Object(n["g"])("br", null, null, -1);

        function wt(t, e, i, a, s, o) {
            var r = Object(n["z"])("my-button"), c = Object(n["z"])("my-icon"), l = Object(n["z"])("font-awesome-icon"),
                d = Object(n["z"])("my-drop-down-search"), u = Object(n["z"])("my-textfield"),
                h = Object(n["z"])("my-alert-window"), f = Object(n["z"])("my-test-form");
            return Object(n["t"])(), Object(n["f"])(n["a"], null, [Object(n["i"])(r, {
                onClick: o.myMethodTest,
                widthButton: 300
            }, {
                default: Object(n["G"])((function () {
                    return [J]
                })), _: 1
            }, 8, ["onClick"]), tt, et, Object(n["i"])(r, {onClick: o.onClickWarnning}, {
                default: Object(n["G"])((function () {
                    return [it]
                })), _: 1
            }, 8, ["onClick"]), nt, Object(n["i"])(r, {onClick: o.onClickYesNo}, {
                default: Object(n["G"])((function () {
                    return [at]
                })), _: 1
            }, 8, ["onClick"]), st, Object(n["i"])(r, {onClick: o.onClickInfo}, {
                default: Object(n["G"])((function () {
                    return [ot]
                })), _: 1
            }, 8, ["onClick"]), rt, Object(n["i"])(r, {onClick: o.onClickRedAlert}, {
                default: Object(n["G"])((function () {
                    return [ct]
                })), _: 1
            }, 8, ["onClick"]), lt, Object(n["i"])(r, {onClick: o.onClickCheck}, {
                default: Object(n["G"])((function () {
                    return [dt]
                })), _: 1
            }, 8, ["onClick"]), ut, Object(n["i"])(r, {onClick: o.onClickRedSkull}, {
                default: Object(n["G"])((function () {
                    return [ht]
                })), _: 1
            }, 8, ["onClick"]), ft, Object(n["i"])(r, {onClick: o.onClickFormular}, {
                default: Object(n["G"])((function () {
                    return [gt]
                })), _: 1
            }, 8, ["onClick"]), bt, Object(n["i"])(c, {svgIconName: "angellist-brands"}), pt, Object(n["i"])(c, {svgIconName: "apps_blue"}), Ot, mt, Object(n["i"])(r, null, {
                default: Object(n["G"])((function () {
                    return [vt, Object(n["i"])(l, {icon: ["fas", "search"], size: "1x"})]
                })), _: 1
            }), Et, jt, Rt, Object(n["i"])(d, {
                pDataMethod: "local",
                pUrlData: "searchTableTest"
            }), Ct, yt, Object(n["i"])(u), Object(n["i"])(h, {
                ref: "refWarnning",
                cWidth: 400,
                cHeight: 200,
                cTypeWindows: 1
            }, null, 512), Object(n["i"])(h, {
                ref: "refYesNo",
                cWidth: 400,
                cHeight: 200,
                cTypeWindows: 3
            }, null, 512), Object(n["i"])(h, {
                ref: "refInfo",
                cWidth: 300,
                cHeight: 200,
                cTypeWindows: 2
            }, null, 512), Object(n["i"])(h, {
                ref: "refRedAlert",
                cWidth: 350,
                cHeight: 200,
                cTypeWindows: 4
            }, null, 512), Object(n["i"])(h, {
                ref: "refCheck",
                cWidth: 350,
                cHeight: 200,
                cTypeWindows: 5
            }, null, 512), Object(n["i"])(h, {
                ref: "refRedSkull",
                cWidth: 200,
                cHeight: 200,
                cTypeWindows: 6
            }, null, 512), Object(n["i"])(f, {ref: "refTestForm"}, null, 512)], 64)
        }

        var Tt = ["src"];

        function _t(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("img", {ref: "refImg", src: this.engine.svgSource}, null, 8, Tt)
        }

        var Dt = {
            name: "my-icon",
            components: {},
            props: {size: {type: Number, default: 15}, svgIconName: {type: String, required: !0}},
            created: function () {
                this.engine.svgSource = i("6f32")("./".concat(this.svgIconName, ".svg"))
            },
            mounted: function () {
                this.$refs.refImg.style.width = this.size + "px"
            },
            methods: {},
            data: function () {
                return {engine: {svgSource: null}}
            }
        };
        const Nt = g()(Dt, [["render", _t]]);
        var At = Nt, St = {ref: "captionRef"}, Lt = {ref: "messageRef"};

        function It(t, e, i, a, s, o) {
            var r = Object(n["z"])("font-awesome-icon"), c = Object(n["z"])("button-ok"),
                l = Object(n["z"])("button-yes"), d = Object(n["z"])("button-no");
            return Object(n["t"])(), Object(n["f"])("div", {
                class: Object(n["o"])(s.windowClass.modal),
                ref: "windowModalRef"
            }, [Object(n["g"])("div", {
                class: Object(n["o"])(s.windowClass.window),
                ref: "windowRef"
            }, [Object(n["g"])("div", {
                class: Object(n["o"])(s.windowClass.header),
                ref: "headerRef"
            }, [Object(n["g"])("span", St, null, 512)], 2), Object(n["g"])("div", {class: Object(n["o"])(s.windowClass.message)}, [Object(n["g"])("div", {
                class: Object(n["o"])(s.windowClass.messageIcon),
                ref: "iconMessageRef"
            }, [Object(n["i"])(r, {
                icon: o.getIconAlertConfig().icon,
                size: "3x",
                style: Object(n["p"])(o.getIconAlertConfig().iconStyleColor)
            }, null, 8, ["icon", "style"])], 2), Object(n["g"])("div", {class: Object(n["o"])(s.windowClass.messageText)}, [Object(n["g"])("p", Lt, null, 512)], 2)], 2), Object(n["g"])("div", {class: Object(n["o"])(s.windowClass.button)}, [Object(n["g"])("div", {class: Object(n["o"])(s.windowClass.buttonAlign)}, [this.cTypeWindows == t.ALERT || this.cTypeWindows == t.INFORMATION || this.cTypeWindows == t.CHECK || this.cTypeWindows == t.REDALERT || this.cTypeWindows == t.SKULL ? (Object(n["t"])(), Object(n["d"])(c, {
                key: 0,
                ref: "buttonOkRef",
                onClick: o.clickOk
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["h"])(Object(n["B"])(o.getIconAlertConfig().captionButton01), 1)]
                })), _: 1
            }, 8, ["onClick"])) : Object(n["e"])("", !0), this.cTypeWindows == t.YESNO ? (Object(n["t"])(), Object(n["d"])(l, {
                key: 1,
                ref: "buttonYesRef",
                onClick: o.clickYes
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["h"])(Object(n["B"])(o.getIconAlertConfig().captionButton01), 1)]
                })), _: 1
            }, 8, ["onClick"])) : Object(n["e"])("", !0), Object(n["g"])("div", {class: Object(n["o"])(s.windowClass.buttonSpace)}, null, 2), this.cTypeWindows == t.YESNO ? (Object(n["t"])(), Object(n["d"])(d, {
                key: 2,
                ref: "buttonNoRef",
                onClick: o.clickNo
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["h"])(Object(n["B"])(o.getIconAlertConfig().captionButton02), 1)]
                })), _: 1
            }, 8, ["onClick"])) : Object(n["e"])("", !0)], 2)], 2), Object(n["g"])("div", {
                class: Object(n["o"])(s.windowClass.bottomLine),
                ref: "colorBottomLineRef"
            }, null, 2)], 2)], 2)
        }

        var Ft = {
            name: "alertWindow-component",
            components: {"button-ok": G, "button-yes": G, "button-no": G, "my-icon": At},
            props: {cWidth: Number, cHeight: Number, cTypeWindows: Number},
            created: function () {
                this.ALERT = 1, this.INFORMATION = 2, this.YESNO = 3, this.REDALERT = 4, this.CHECK = 5, this.SKULL = 6, this.ALERT_COLOR = "#DED208", this.INFORMATION_COLOR = "#15BEF8", this.YESNO_COLOR = "#22C206", this.REDALERT_COLOR = "red", this.CHECK_COLOR = "#15BEF8", this.SKULL_COLOR = "red"
            },
            mounted: function () {
                this.$refs.windowRef.style.width = this.cWidth + "px", this.$refs.colorBottomLineRef.style.background = this.getIconAlertConfig().iconColor, this.$vanilla.dragDiv(this.$refs.windowRef, this.$refs.headerRef)
            },
            data: function () {
                return {
                    windowClass: {
                        modal: "alertWindow",
                        window: "window",
                        header: "header",
                        message: "message",
                        messageIcon: "messageIcon",
                        messageText: "messageText",
                        button: "button",
                        buttonAlign: "button-align",
                        buttonSpace: "button-space",
                        bottomLine: "bottom-line"
                    }, pressOk: 0, pressYes: 0, pressNo: 0, myEmit: {ok: "emitOkButton", yesNo: "emitYesNoButton"}
                }
            },
            methods: {
                setCaption: function (t) {
                    this.$refs.captionRef.innerHTML = t
                }, setMessage: function (t) {
                    this.$refs.messageRef.innerHTML = t
                }, clickOk: function () {
                    this.pressOk = 1, this.$emit(this.myEmit.ok), this.close()
                }, clickYes: function () {
                    this.pressYes = 1, this.pressNo = 0, this.$emit(this.myEmit.yesNo, this.pressYes), this.close()
                }, clickNo: function () {
                    this.pressYes = 0, this.pressNo = 1, this.$emit(this.myEmit.yesNo, this.pressYes), this.close()
                }, close: function () {
                    this.$refs.windowModalRef.style.display = "none"
                }, show: function () {
                    this.ok = 0, this.$refs.windowModalRef.style.display = "table", this.$check.isUndef(this.$refs.buttonOkRef) || this.$refs.buttonOkRef.$el.focus(), this.$check.isUndef(this.$refs.buttonNoRef) || this.$refs.buttonNoRef.$el.focus()
                }, getIconAlertConfig: function () {
                    var t = null, e = "Ok", i = "No", n = null;
                    return this.cTypeWindows == this.ALERT ? (t = ["fas", "exclamation-triangle"], n = this.ALERT_COLOR) : this.cTypeWindows == this.INFORMATION ? (t = ["fas", "exclamation"], n = this.INFORMATION_COLOR) : this.cTypeWindows == this.YESNO ? (t = ["fas", "question"], n = this.YESNO_COLOR, e = "Yes", i = "No") : this.cTypeWindows == this.REDALERT ? (t = ["fas", "exclamation-circle"], n = this.REDALERT_COLOR) : this.cTypeWindows == this.CHECK ? (t = ["fas", "check"], n = this.CHECK_COLOR) : this.cTypeWindows == this.SKULL && (t = ["fas", "skull-crossbones"], n = this.SKULL_COLOR), {
                        iconColor: n,
                        iconStyleColor: {color: n},
                        icon: t,
                        captionButton01: e,
                        captionButton02: i
                    }
                }
            }
        };
        const $t = g()(Ft, [["render", It]]);
        var kt = $t, Bt = ["id"], Mt = {class: "caption", ref: "captionRef"}, Pt = {class: "ff-form-table"},
            xt = {class: "label bold"}, Gt = ["for"], Ut = {class: "control"}, Ht = {class: "label bold"}, zt = ["for"],
            Wt = {class: "control"}, Vt = {class: "label bold"}, Yt = ["for"], Kt = {class: "control"},
            qt = {class: "label-right bold"}, Qt = ["for"], Zt = {class: "control"}, Xt = {class: "label bold"},
            Jt = ["for"], te = {colspan: "2", class: "control"}, ee = Object(n["h"])("Send data");

        function ie(t, e, i, a, s, o) {
            var r = Object(n["z"])("validate-window"), c = Object(n["z"])("font-awesome-icon"),
                l = Object(n["z"])("test-field"), d = Object(n["z"])("check-box"), u = Object(n["z"])("lista-numere"),
                h = Object(n["z"])("button-send");
            return Object(n["t"])(), Object(n["f"])(n["a"], null, [Object(n["i"])(r, {
                ref: "validateWindowRef",
                cWidth: 500,
                cHeight: 200,
                cTypeWindows: 1
            }, null, 512), Object(n["i"])(r, {
                ref: "infoWindowRef",
                cWidth: 300,
                cHeight: 200,
                cTypeWindows: 5
            }, null, 512), Object(n["i"])(r, {
                ref: "redWindowRef",
                cWidth: 400,
                cHeight: 200,
                cTypeWindows: 6
            }, null, 512), Object(n["g"])("div", {
                class: Object(n["o"])(s.formClass.container),
                ref: t.CONTAINER_REF,
                id: s.cfgForm.id
            }, [Object(n["g"])("div", {
                class: Object(n["o"])(s.formClass.header),
                ref: "headerRef"
            }, [Object(n["g"])("span", Mt, null, 512), Object(n["g"])("div", {
                class: "closeButton",
                onClick: e[0] || (e[0] = function () {
                    return o.closeForm && o.closeForm.apply(o, arguments)
                })
            }, [Object(n["i"])(c, {icon: s.cfgForm.closeIcon}, null, 8, ["icon"])])], 2), Object(n["g"])("div", {
                class: Object(n["o"])(s.formClass.content),
                ref: "contentRef"
            }, [Object(n["g"])("form", null, [Object(n["g"])("table", Pt, [Object(n["g"])("tr", null, [Object(n["g"])("td", xt, [Object(n["g"])("label", {for: t.NUME.id}, Object(n["B"])(t.NUME.caption), 9, Gt)]), Object(n["g"])("td", Ut, [Object(n["i"])(l, {
                id: t.NUME.id,
                ref: t.NUME.ref,
                maska: "",
                validate: t.NUME.validate,
                minlength: t.NUME.minLength,
                maxlength: t.NUME.maxLength,
                size: t.NUME.sizeField
            }, null, 8, ["id", "validate", "minlength", "maxlength", "size"])]), Object(n["g"])("td", Ht, [Object(n["g"])("label", {for: t.PRENUME.id}, Object(n["B"])(t.PRENUME.caption), 9, zt)]), Object(n["g"])("td", Wt, [Object(n["i"])(l, {
                id: t.PRENUME.id,
                ref: t.PRENUME.ref,
                maska: "",
                validate: t.PRENUME.validate,
                minlength: t.PRENUME.minLength,
                maxlength: t.PRENUME.maxLength,
                size: t.PRENUME.sizeField
            }, null, 8, ["id", "validate", "minlength", "maxlength", "size"])])]), Object(n["g"])("tr", null, [Object(n["g"])("td", Vt, [Object(n["g"])("label", {for: t.AGE.id}, Object(n["B"])(t.AGE.caption), 9, Yt)]), Object(n["g"])("td", Kt, [Object(n["i"])(l, {
                id: t.AGE.id,
                ref: t.AGE.ref,
                maska: "",
                validate: t.AGE.validate,
                minlength: t.AGE.minLength,
                maxlength: t.AGE.maxLength,
                size: t.AGE.sizeField
            }, null, 8, ["id", "validate", "minlength", "maxlength", "size"])]), Object(n["g"])("td", qt, [Object(n["g"])("label", {for: t.CONF_ACORD.id}, Object(n["B"])(t.CONF_ACORD.caption), 9, Qt)]), Object(n["g"])("td", Zt, [Object(n["i"])(d, {
                id: t.CONF_ACORD.id,
                ref: t.CONF_ACORD.ref,
                validate: t.CONF_ACORD.validate,
                defaultValue: t.CONF_ACORD.defaultValue,
                size: t.CONF_ACORD.sizeField,
                disabled: t.CONF_ACORD.disabled
            }, null, 8, ["id", "validate", "defaultValue", "size", "disabled"])])]), Object(n["g"])("tr", null, [Object(n["g"])("td", Xt, [Object(n["g"])("label", {for: t.SELECT_OPTION.id}, Object(n["B"])(t.SELECT_OPTION.caption), 9, Jt)]), Object(n["g"])("td", te, [Object(n["i"])(u, {
                pId: t.SELECT_OPTION.id,
                ref: t.SELECT_OPTION.ref,
                pName: t.SELECT_OPTION.ref,
                pCaptionText: "... alege un numar",
                pWidth: t.SELECT_OPTION.width,
                validate: t.SELECT_OPTION.validate
            }, null, 8, ["pId", "pName", "pCaptionText", "pWidth", "validate"])])])])])], 2), Object(n["g"])("div", {class: Object(n["o"])(s.formClass.button)}, [Object(n["g"])("div", {class: Object(n["o"])(s.formClass.buttonPozition)}, [Object(n["i"])(h, {onClick: o.sendData}, {
                default: Object(n["G"])((function () {
                    return [ee]
                })), _: 1
            }, 8, ["onClick"])], 2)], 2), Object(n["g"])("div", {class: Object(n["o"])(s.formClass.bottomLine)}, null, 2)], 10, Bt)], 64)
        }

        var ne = {class: "ff-input-text"}, ae = ["id", "name", "minlength", "maxlength", "size", "placeholder"];

        function se(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("div", ne, [Object(n["H"])(Object(n["g"])("input", {
                id: this.id,
                name: this.id,
                minlength: this.minlength,
                maxlength: this.maxlength,
                "onUpdate:modelValue": e[0] || (e[0] = function (t) {
                    return s.dataModel = t
                }),
                ref: "inputRef",
                size: this.size,
                placeholder: this.pPlaceHolder
            }, null, 8, ae), [[n["E"], s.dataModel]])])
        }

        var oe = i("795b"), re = {
            name: "my-textField",
            props: {
                id: String,
                maska: String,
                validate: Function,
                minlength: Number,
                maxlength: Number,
                size: Number,
                pPlaceHolder: {type: String, default: "input data ...", required: !1}
            },
            directives: {maska: oe["a"]},
            mounted: function () {
                this.vModelData = null
            },
            methods: {
                getValue: function () {
                    return this.dataModel
                }, keydownPress: function () {
                    event.target.id == this.id && console.log(this.getValue())
                }
            },
            data: function () {
                return {dataModel: null}
            }
        };
        const ce = g()(re, [["render", se]]);
        var le = ce, de = ["id", "name", "size", "disabled"];

        function ue(t, e, i, a, s, o) {
            return Object(n["H"])((Object(n["t"])(), Object(n["f"])("input", {
                type: "checkbox",
                id: this.id,
                name: this.id,
                size: this.size,
                "onUpdate:modelValue": e[0] || (e[0] = function (t) {
                    return s.dataModel = t
                }),
                disabled: this.disabled
            }, null, 8, de)), [[n["D"], s.dataModel]])
        }

        var he = {
            name: "my-checkBox",
            props: {
                id: String,
                caption: String,
                validate: Function,
                defaultValue: Boolean,
                disabled: Boolean,
                size: Number
            },
            directives: {},
            mounted: function () {
                this.dataModel = this.defaultValue
            },
            methods: {
                getValue: function () {
                    return this.dataModel
                }, resetValue: function () {
                    this.dataModel = this.defaultValue
                }, keydownPress: function () {
                }
            },
            data: function () {
                return {dataModel: !0}
            }
        };
        const fe = g()(he, [["render", ue]]);
        var ge = fe, be = {class: "ff-dropdown-simple"}, pe = ["name", "id", "disabled"], Oe = ["value", "selected"];

        function me(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("div", be, [Object(n["g"])("select", {
                name: i.pName,
                id: i.pId,
                ref: t.SELECT_REF,
                onChange: e[0] || (e[0] = function () {
                    return o.changeValue && o.changeValue.apply(o, arguments)
                }),
                disabled: this.isDisabled
            }, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(s.dataList, (function (t) {
                return Object(n["t"])(), Object(n["f"])("option", {
                    value: t.id,
                    selected: t.selected
                }, Object(n["B"])(t.text), 9, Oe)
            })), 256))], 40, pe)])
        }

        var ve = {
            name: "my-dropDown-simple",
            props: {pId: String, pName: String, pCaptionText: String, pWidth: Number, validate: Function},
            created: function () {
                this.SELECT_REF = "selectRef"
            },
            mounted: function () {
                this.config()
            },
            methods: {
                changeValue: function () {
                    var t = this.$refs[this.SELECT_REF];
                    this.setValue(t.options[t.selectedIndex].value, t.options[t.selectedIndex].text)
                }, setValue: function (t, e) {
                    this.dataSelected.id = t, this.dataSelected.text = e
                }, getValue: function () {
                    return this.dataSelected
                }, enabled: function (t) {
                    this.isDisabled = !t
                }, dataTest: function () {
                    var t = [{id: 0, text: this.pCaptionText, selected: !0}];
                    return t.push({id: 100, text: "cifra 100", selected: !1}, {
                        id: 200,
                        text: "cifra 200",
                        selected: !1
                    }, {id: 300, text: "cifra 300", selected: !1}, {id: 400, text: "cifra 400", selected: !1}, {
                        id: 500,
                        text: "cifra 500 un text mult mai lung",
                        selected: !1
                    }, {id: 600, text: "cifra 600", selected: !1}), t
                }, config: function () {
                    this.pWidth > 0 && (this.$refs[this.SELECT_REF].style.width = this.pWidth + "px"), this.enabled(!0)
                }
            },
            computed: {},
            data: function () {
                return {dataList: this.dataTest(), dataSelected: {id: 0, text: null}, isDisabled: !0}
            }
        };
        const Ee = g()(ve, [["render", me]]);
        var je = Ee, Re = {
            components: {
                "test-field": le,
                "check-box": ge,
                "button-send": G,
                "validate-window": kt,
                "lista-numere": je
            }, name: "test-form-component", created: function () {
                this.CONTAINER_REF = "containerRef", this.NUME = this.cfgNume(), this.PRENUME = this.cfgPreNume(), this.AGE = this.cfgVarsta(), this.CONF_ACORD = this.cfgConfirmareAcord(), this.SELECT_OPTION = this.cfgSimpleSelect()
            }, mounted: function () {
                this.configForm()
            }, methods: {
                closeForm: function () {
                    this.$refs[this.CONTAINER_REF].style.display = "none"
                }, showForm: function () {
                    this.$refs[this.CONTAINER_REF].style.display = "table"
                }, cfgConfirmareAcord: function () {
                    var t = this.$app.cfgCheckBox();
                    return t.setIdAndRef("confirmare"), t.validate = this.validateConfirmare, t.caption = "Confirm", t.defaultValue = !1, t.disabled = !1, t
                }, cfgVarsta: function () {
                    var t = this.$app.cfgTextFIeld();
                    return t.setIdAndRef("age"), t.minLength = 3, t.maxLength = 3, t.validate = this.validateAge, t.maska = "", t.caption = "Varsta", t.mandatory = !1, t.sizeField = 7, t
                }, cfgSimpleSelect: function () {
                    var t = this.$app.cfgSelectSimple();
                    return t.setIdAndRef("listaNumar"), t.validate = this.validateListaNumar, t.caption = "Lista numere", t
                }, cfgNume: function () {
                    var t = this.$app.cfgTextFIeld();
                    return t.setIdAndRef("nume"), t.minLength = 3, t.maxLength = 10, t.validate = this.validateNume, t.maska = "", t.caption = "Nume", t.mandatory = !1, t.sizeField = 10, t
                }, cfgPreNume: function () {
                    var t = this.$app.cfgTextFIeld();
                    return t.setIdAndRef("prenume"), t.minLength = 4, t.maxLength = 20, t.validate = this.validatePreNume, t.maska = "", t.caption = "Prenume referinta mai mare", t.mandatory = !1, t.sizeField = 30, t
                }, configForm: function () {
                    this.cfgForm.id = "777TEST", this.cfgForm.closeIcon = ["fas", "times"], this.$refs.captionRef.innerHTML = "Introducere date de test", this.$vanilla.dragDiv(this.$refs.containerRef, this.$refs.headerRef)
                }, sendData: function () {
                    var t = this;
                    if (this.validateForm(), this.messageForm.length > 0) return this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate"), this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.messageForm)), this.$refs.validateWindowRef.show(), !1;
                    this.post.nume = this.$refs.numeRef.getValue(), this.post.prenume = this.$refs.prenumeRef.getValue(), this.post.accept = this.$refs.confirmareRef.getValue(), console.log("accept: " + this.post.accept);
                    var e = this.$url.getUrl("addName");
                    this.axios.post(e, this.post).then((function (e) {
                        e.data.succes ? (t.$refs.infoWindowRef.setCaption("Succes"), t.$refs.infoWindowRef.setMessage(t.$appServer.getHtmlSqlFormatMessage(e.data)), t.$refs.infoWindowRef.show()) : (t.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate"), t.$refs.validateWindowRef.setMessage(t.$appServer.getHtmlSqlFormatMessage(e.data)), t.$refs.validateWindowRef.show())
                    })).catch((function (e) {
                        t.$refs.redWindowRef.setCaption("Probleme ... "), t.$refs.redWindowRef.setMessage(e), t.$refs.redWindowRef.show()
                    }))
                }, validateAge: function () {
                    this.$refs[this.AGE.ref].getValue() < 5 && this.messageForm.push(this.$app.getFormMessageClass(this.AGE.id, this.AGE.caption, "trebuie sa fie mai mare de cinci ani."))
                }, validateForm: function () {
                    this.messageForm = [], this.$check.validateForm(this.$refs)
                }, validateNume: function () {
                    this.$check.lenghtMinMax(this.$refs[this.NUME.ref].getValue(), this.NUME.minLength, this.NUME.maxLength) || this.messageForm.push(this.$app.getFormMessageClass(this.NUME.id, this.NUME.caption, "trebuie sa aiba minim " + this.NUME.minLength + " si maxim " + this.NUME.maxLength + " caractere"))
                }, validatePreNume: function () {
                    this.$check.lenghtMinMax(this.$refs[this.PRENUME.ref].getValue(), this.PRENUME.minLength, this.PRENUME.maxLength) || this.messageForm.push(this.$app.getFormMessageClass(this.PRENUME.id, this.PRENUME.caption, "trebuie sa aiba minim " + this.PRENUME.minLength + " si maxim " + this.PRENUME.maxLength + " caractere"))
                }, validateConfirmare: function () {
                }, validateListaNumar: function () {
                    console.log("trece pe aici !!! 1000");
                    var t = this.$refs[this.SELECT_OPTION.ref].getValue();
                    0 == t.id && this.messageForm.push(this.$app.getFormMessageClass(this.SELECT_OPTION.id, this.SELECT_OPTION.caption, "trebuie sa alegi un numar din lista"))
                }
            }, data: function () {
                return {
                    formClass: this.$css.getCss("form"),
                    messageForm: [],
                    post: {nume: null, prenume: null, accept: !1},
                    cfgForm: {id: null, closeIcon: ["fas", "times"]}
                }
            }
        };
        const Ce = g()(Re, [["render", ie]]);
        var ye = Ce, we = {class: "ff-dropdown-search"}, Te = ["placeholder"];

        function _e(t, e, i, a, s, o) {
            var r = Object(n["z"])("font-awesome-icon"), c = Object(n["z"])("list-rezult");
            return Object(n["t"])(), Object(n["f"])("div", we, [Object(n["g"])("input", {
                ref: t.REF_SEARCH,
                type: "text",
                onKeyup: e[0] || (e[0] = function () {
                    return o.keySearch && o.keySearch.apply(o, arguments)
                }),
                placeholder: this.pPlaceHolder
            }, null, 40, Te), Object(n["g"])("div", {
                class: "icon",
                ref: t.REF_ICON,
                onClick: e[1] || (e[1] = function () {
                    return o.iconClick && o.iconClick.apply(o, arguments)
                })
            }, [Object(n["i"])(r, {icon: ["fas", "search"], size: "2x"})], 512), Object(n["g"])("div", {
                class: "rezult",
                ref: t.REF_REZULT
            }, [(Object(n["t"])(), Object(n["d"])(c, {
                ref: "selectDataFromListRef",
                pData: this.rezultData,
                onSelectData: o.emitSelectData,
                onTabKey: o.emitPressTabKey,
                key: this.engine.keyRender
            }, null, 8, ["pData", "onSelectData", "onTabKey"]))], 512)])
        }

        i("caad"), i("2532"), i("4de4"), i("d3b7"), i("ac1f"), i("841c");
        var De = {class: "ff-table-list"}, Ne = ["id"], Ae = ["tabindex"],
            Se = Object(n["g"])("div", null, [Object(n["g"])("span", null, "info nr records")], -1), Le = [Se];

        function Ie(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("div", De, [Object(n["g"])("div", {
                class: "tableDiv",
                ref: t.REF_TABLEDIV
            }, [Object(n["g"])("table", {ref: t.REF_TABLE}, [Object(n["g"])("thead", {ref: t.REF_HEAD}, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(i.pHeader, (function (t) {
                return Object(n["t"])(), Object(n["f"])("tr", null, [Object(n["g"])("th", null, Object(n["B"])(t.caption), 1)])
            })), 256))], 512), Object(n["g"])("tbody", {ref: t.REF_BODY}, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(i.pData, (function (t) {
                return Object(n["t"])(), Object(n["f"])("tr", {
                    id: t.id,
                    onKeydown: e[0] || (e[0] = Object(n["I"])((function (t) {
                        return o.keyNavigate(t)
                    }), ["prevent"])),
                    onClick: e[1] || (e[1] = Object(n["I"])((function (t) {
                        return o.mouseNavigate(t)
                    }), ["prevent"]))
                }, [Object(n["g"])("td", {tabindex: t.id}, Object(n["B"])(t.caption), 9, Ae)], 40, Ne)
            })), 256))], 512)], 512)], 512), Object(n["g"])("div", {
                class: "infoList",
                ref: t.REF_BOTTOM_INFO
            }, Le, 512)])
        }

        var Fe = {
            name: "table-list", created: function () {
                this.REF_TABLE = "tTableRef", this.REF_TABLEDIV = "tTableDivRef", this.REF_HEAD = "tHeadRef", this.REF_BODY = "tBodyRef", this.REF_BOTTOM_INFO = "tBottomInfo", this.CLASS_SELECTED = "selected", this.MAX_REZULT_COUNT = 10, this.MAX_REZULT_DIV_HEIGHT = "212px"
            }, props: {pHeader: {type: Array, required: !1}, pData: {type: Array, required: !0}}, mounted: function () {
                this.initTable()
            }, methods: {
                initTable: function () {
                    this.engine.maximRows = this.pData.length, this.engine.maximRows > 0 && this.setTDselected(this.$refs[this.REF_TABLE].rows[0].childNodes[0]);
                    var t = "none", e = null, i = "100%";
                    this.engine.maximRows > this.MAX_REZULT_COUNT && (e = "scroll", t = "block", i = this.MAX_REZULT_DIV_HEIGHT, this.$refs[this.REF_BOTTOM_INFO].childNodes[0].textContent = " ...found " + this.engine.maximRows + " records in the list"), this.$refs[this.REF_TABLEDIV].style.height = i, this.$refs[this.REF_TABLEDIV].style["overflow-y"] = e, this.$refs[this.REF_BOTTOM_INFO].style.display = t
                }, mouseNavigate: function (t) {
                    this.setTDselected(t.target), this.selectData(), this.$emit(this.engine.emit.selectData)
                }, keyNavigate: function (t) {
                    "ArrowRight" == t.key || "ArrowLeft" == t.key || ("ArrowDown" == t.key ? this.arrowDown() : "ArrowUp" == t.key ? this.arrowUp() : "Enter" == t.key ? (this.selectData(), this.$emit(this.engine.emit.selectData)) : "Tab" == t.key && this.$emit(this.engine.emit.tabKey))
                }, arrowRight: function () {
                }, arrowLeft: function () {
                }, arrowUp: function () {
                    this.engine.trCurent.sectionRowIndex > 0 && (this.setTDselected(this.engine.tdCurent.parentNode.previousSibling.getElementsByTagName("td")[0]), this.selectData())
                }, arrowDown: function () {
                    this.engine.trCurent.sectionRowIndex < this.engine.maximRows - 1 && (this.setTDselected(this.engine.tdCurent.parentNode.nextSibling.getElementsByTagName("td")[0]), this.selectData())
                }, setFocus: function () {
                    this.engine.tdCurent.focus()
                }, selectData: function () {
                    this.dataSelected.id = this.engine.trCurent.getAttribute("id"), this.dataSelected.caption = this.engine.tdCurent.innerHTML
                }, setTDselected: function (t) {
                    null != this.engine.tdCurent && this.engine.tdCurent.removeAttribute("class", this.CLASS_SELECTED), this.engine.tdCurent = t, this.engine.trCurent = t.parentNode, this.engine.tdCurent.setAttribute("class", this.CLASS_SELECTED), this.setFocus()
                }, getDataSelected: function () {
                    return this.dataSelected
                }, getCountRecords: function () {
                    return this.engine.maximRows
                }
            }, data: function () {
                return {
                    engine: {
                        tdCurent: null,
                        trCurent: null,
                        maximRows: 0,
                        emit: {selectData: "selectData", tabKey: "tabKey"}
                    }, dataSelected: {id: 0, caption: null}
                }
            }
        };
        const $e = g()(Fe, [["render", Ie]]);
        var ke = $e, Be = {
            name: "drop-down-search",
            created: function () {
                this.REF_SEARCH = "searchRef", this.REF_ICON = "iconRef", this.REF_REZULT = "rezultRef", this.REF_TABLE_REZULT = "tableRef", this.DATA_METHOD_LOCAL = "local", this.DATA_METHOD_SERVER = "server", this.LAST_LETTERS_NUMBER_FOR_SEARCH = 3, this.DELAY_FOR_SEARCCING = 600, this.MAX_REZULT_COUNT = 10, this.MAX_REZULT_DIV_HEIGHT = "300px", this.KEY_PRESS_CONTROL_BROWSER = ["Tab", "Escape"]
            },
            props: {
                pDataMethod: {type: String, required: !0},
                pUrlData: {type: String, required: !0},
                pPlaceHolder: {type: String, default: "... search", required: !1}
            },
            components: {"list-rezult": ke},
            mounted: function () {
                this.pDataMethod == this.DATA_METHOD_LOCAL && this.getDataFromServer()
            },
            methods: {
                emitSelectData: function () {
                    this.setDataSelected(this.$refs.selectDataFromListRef.getDataSelected()), this.hideOption()
                }, emitPressTabKey: function () {
                    this.$refs[this.REF_SEARCH].focus()
                }, setDataSelected: function (t) {
                    this.dataSelected = t, this.$refs[this.REF_SEARCH].value = this.dataSelected.caption
                }, resetDataSelected: function () {
                    this.dataSelected = null
                }, iconClick: function () {
                    this.$refs[this.REF_SEARCH].focus()
                }, keySearch: function (t) {
                    this.KEY_PRESS_CONTROL_BROWSER.includes(t.key) || (this.post.wordSearch = this.$refs[this.REF_SEARCH].value, this.resetDataSelected(), this.delaySearchCancel(), this.post.wordSearch.length >= this.LAST_LETTERS_NUMBER_FOR_SEARCH ? this.delaySearch() : this.hideOption())
                }, hideOption: function () {
                    this.resetRezultData(), this.showOptionList()
                }, resetRezultData: function () {
                    this.rezultData = new Array
                }, showOptionList: function () {
                    ++this.engine.keyRender;
                    var t = "none";
                    this.rezultData.length > 0 && (t = "block"), this.$refs[this.REF_REZULT].style.display = t
                }, search: function () {
                    var t = this;
                    this.pDataMethod == this.DATA_METHOD_LOCAL && (this.rezultData = this.localData.filter((function (e) {
                        return -1 !== e.caption.toLowerCase().indexOf(t.post.wordSearch.toLowerCase())
                    })), this.showOptionList()), this.pDataMethod == this.DATA_METHOD_SERVER && this.getDataFromServer()
                }, delaySearch: function () {
                    var t = this;
                    this.timeOut = setTimeout((function () {
                        return t.search()
                    }), this.DELAY_FOR_SEARCCING)
                }, delaySearchCancel: function () {
                    null != this.timeOut && clearTimeout(this.timeOut)
                }, getDataFromServer: function () {
                    var t = this, e = this.$url.getUrl(this.pUrlData);
                    this.axios.post(e, this.post).then((function (e) {
                        t.pDataMethod == t.DATA_METHOD_LOCAL && (t.localData = e.data), t.pDataMethod == t.DATA_METHOD_SERVER && (t.rezultData = e.data, t.showOptionList())
                    })).catch((function (t) {
                        return console.log(t)
                    }))
                }
            },
            data: function () {
                return {
                    engine: {keyRender: 1},
                    localData: null,
                    rezultData: new Array,
                    countRezultData: 0,
                    timeOut: null,
                    post: {wordSearch: null},
                    dataSelected: null
                }
            }
        };
        const Me = g()(Be, [["render", _e]]);
        var Pe = Me, xe = {
            name: "controale",
            components: {
                "my-icon": At,
                "my-button": G,
                "my-alert-window": kt,
                "my-test-form": ye,
                "my-drop-down-search": Pe,
                "my-textfield": le
            },
            mounted: function () {
            },
            methods: {
                myMethodTest: function () {
                    console.log("click pe butonul")
                }, onClickWarnning: function () {
                    this.$refs.refWarnning.setMessage("Atentie, datele tale sunt alterate !!!"), this.$refs.refWarnning.show()
                }, onClickYesNo: function () {
                    this.$refs.refYesNo.setMessage("Esti sigur ca vrei sa stergi datele la care ai muncit asa de mult ?"), this.$refs.refYesNo.show()
                }, onClickInfo: function () {
                    this.$refs.refInfo.setMessage("Datele au fost salvate in sistem ?"), this.$refs.refInfo.show()
                }, onClickRedAlert: function () {
                    this.$refs.refRedAlert.setMessage("Alarma rosie !!! Alarma rosie !!!"), this.$refs.refRedAlert.show()
                }, onClickCheck: function () {
                    this.$refs.refCheck.setMessage("Verific (check) in aplicatie."), this.$refs.refCheck.show()
                }, onClickRedSkull: function () {
                    console.log("call de doua ori RedSkull !!!!"), this.$refs.refRedSkull.setMessage("Radiatii. <br> Moarte !!!"), this.$refs.refRedSkull.show()
                }, onClickFormular: function () {
                    this.$refs.refTestForm.showForm()
                }
            }
        };
        const Ge = g()(xe, [["render", wt]]);
        var Ue = Ge, He = {class: "ff-grid-all", ref: "refGridPrint"};

        function ze(t, e, i, a, s, o) {
            var r = Object(n["z"])("my-grid"), c = Object(n["z"])("my-grid-edit");
            return Object(n["t"])(), Object(n["f"])("div", He, [Object(n["i"])(r, {
                ref: "gridPrint",
                pConfig: this.gridConfig,
                onInvoicePrint: o.invoicePrint,
                onEditCeva: o.editCeva,
                onDeleteCevaToolbar: o.deleteCevaToolbar,
                onEditCevaToolbar: o.editCevaToolbar
            }, null, 8, ["pConfig", "onInvoicePrint", "onEditCeva", "onDeleteCevaToolbar", "onEditCevaToolbar"]), Object(n["i"])(c, {
                ref: "refGridEdit",
                onEmitUpdateGrid: o.emitUpdateGrid
            }, null, 8, ["onEmitUpdateGrid"])], 512)
        }

        var We = {key: 0, class: "ff-grid-loading-modal"}, Ve = {idPk: -1}, Ye = ["id"], Ke = {class: "divHeader"},
            qe = {class: "divCaptionFilter"}, Qe = {key: 0, class: "divFilter"}, Ze = ["title"],
            Xe = {key: 0, class: "divOrder"}, Je = ["id"], ti = ["title"], ei = ["idPk"], ii = ["tabindex"],
            ni = ["title", "fieldName"], ai = ["tabindex"], si = {class: "div--center-align-action-group"},
            oi = {class: "toolbar-icon-inline"}, ri = {class: "divButton"},
            ci = Object(n["g"])("tfoot", null, null, -1), li = {class: "toolbar"}, di = {class: "divButton"},
            ui = ["title"], hi = {class: "paginate"}, fi = {class: "divButton"}, gi = {class: "divButton"},
            bi = {key: 0, class: "divButtonDinamic"}, pi = {key: 1, class: "divButtonDinamic"},
            Oi = Object(n["g"])("div", {class: "divSapacer", style: {widht: "35px"}}, null, -1), mi = [Oi],
            vi = {class: "divButton"}, Ei = {class: "divButton"}, ji = {class: "divButtonGoTo"},
            Ri = Object(n["h"])(" Goto page "), Ci = {class: "divInputGoto"}, yi = ["title"];

        function wi(t, e, i, a, s, o) {
            var r = this, c = Object(n["z"])("font-awesome-icon"), l = Object(n["z"])("my-button"),
                d = Object(n["z"])("my-input-field"), u = Object(n["z"])("page-nr-field");
            return Object(n["t"])(), Object(n["f"])("div", {
                class: "ff-grid-container",
                ref: this.REF_DIV_CONTAINER
            }, [this.showModalLoadingDiv ? (Object(n["t"])(), Object(n["f"])("div", We, [Object(n["g"])("div", null, [Object(n["i"])(c, {
                icon: this.$constComponent.ICON_SPINNER,
                size: "4x",
                spin: ""
            }, null, 8, ["icon"])])])) : Object(n["e"])("", !0), Object(n["g"])("div", {
                class: "ff-grid",
                ref: this.REF_DIV_TABLE
            }, [Object(n["g"])("table", {
                class: "ff-table",
                ref: t.REF_TABLE
            }, [Object(n["g"])("thead", {
                class: "ff-thead",
                ref: this.REF_THEAD
            }, [Object(n["g"])("tr", Ve, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(i.pConfig.header, (function (t) {
                return Object(n["t"])(), Object(n["f"])(n["a"], null, ["field" == t.type ? (Object(n["t"])(), Object(n["f"])("th", {
                    key: 0,
                    id: t.id,
                    class: "th th--left-align"
                }, [Object(n["g"])("div", Ke, [Object(n["g"])("div", qe, [t.filterBy ? (Object(n["t"])(), Object(n["f"])("div", Qe, [Object(n["i"])(l, {
                    onClick: e[0] || (e[0] = function (t) {
                        return r.privateShowFilterDiv(t)
                    }),
                    heightButton: 22,
                    buttonType: 1,
                    style: Object(n["p"])(o.privateShowMarkFilter(t.id)),
                    title: "filter..."
                }, {
                    default: Object(n["G"])((function () {
                        return [Object(n["i"])(c, {
                            icon: r.cfgIconPictureAction(r.$constGrid.ICON_FILTER),
                            size: "1x"
                        }, null, 8, ["icon"])]
                    })), _: 2
                }, 1032, ["style", "title"])])) : Object(n["e"])("", !0), Object(n["g"])("div", {
                    class: "divCaption",
                    title: t.caption
                }, Object(n["B"])(t.caption), 9, Ze), t.filterBy ? (Object(n["t"])(), Object(n["f"])("div", {
                    key: 1,
                    class: Object(n["o"])(["divDataFilter", {divDataFilterDisplayOn: r.privateReactiveShowFilterDiv(t.id)}])
                }, [Object(n["i"])(d, {
                    size: 20,
                    pPlaceHolder: "...",
                    onKeyup: o.privateKeyPresFilter
                }, null, 8, ["pPlaceHolder", "onKeyup"]), Object(n["i"])(l, {
                    onClick: e[1] || (e[1] = function (t) {
                        return r.privateClearFilter(t)
                    }),
                    heightButton: 22,
                    buttonType: 1,
                    title: "clear filter",
                    style: Object(n["p"])(o.cfgIconColor(r.$constGrid.ICON_DELETE.color))
                }, {
                    default: Object(n["G"])((function () {
                        return [Object(n["i"])(c, {
                            icon: r.cfgIconPictureAction(r.$constGrid.ICON_DELETE),
                            size: "1x"
                        }, null, 8, ["icon"])]
                    })), _: 1
                }, 8, ["style"])], 2)) : Object(n["e"])("", !0)]), t.orderBy.order ? (Object(n["t"])(), Object(n["f"])("div", Xe, [Object(n["i"])(l, {
                    idheader: t.id,
                    onClick: e[2] || (e[2] = function (t) {
                        return r.privateOrderBy(t)
                    }),
                    heightButton: 22,
                    buttonType: 1,
                    style: Object(n["p"])(o.cfgIconColor("white")),
                    title: "order ..."
                }, {
                    default: Object(n["G"])((function () {
                        return [1 == r.privateIconOrderBy(t.id) ? (Object(n["t"])(), Object(n["d"])(c, {
                            key: 0,
                            icon: r.cfgIconPictureAction(r.$constGrid.ICON_UP_ORDER),
                            size: "1x"
                        }, null, 8, ["icon"])) : Object(n["e"])("", !0), 2 == r.privateIconOrderBy(t.id) ? (Object(n["t"])(), Object(n["d"])(c, {
                            key: 1,
                            icon: r.cfgIconPictureAction(r.$constGrid.ICON_DOWN_ORDER),
                            size: "1x"
                        }, null, 8, ["icon"])) : Object(n["e"])("", !0), 0 == r.privateIconOrderBy(t.id) ? (Object(n["t"])(), Object(n["d"])(c, {
                            key: 2,
                            icon: r.cfgIconPictureAction(r.$constGrid.ICON_ORDER),
                            size: "1x"
                        }, null, 8, ["icon"])) : Object(n["e"])("", !0)]
                    })), _: 2
                }, 1032, ["idheader", "style", "title"])])) : Object(n["e"])("", !0)])], 8, Ye)) : Object(n["e"])("", !0), "field" !== t.type ? (Object(n["t"])(), Object(n["f"])("th", {
                    key: 1,
                    id: t.id,
                    class: "th th--center-align"
                }, [Object(n["g"])("div", {
                    class: "divCaption",
                    title: t.caption
                }, Object(n["B"])(t.caption), 9, ti)], 8, Je)) : Object(n["e"])("", !0)], 64)
            })), 256))])], 512), Object(n["g"])("tbody", {
                class: "ff-tbody",
                ref: t.REF_TABLE_BODY
            }, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(this.paginate.pag.data, (function (t, a) {
                return Object(n["t"])(), Object(n["f"])("tr", {
                    idPk: t.id,
                    onKeydown: e[3] || (e[3] = Object(n["I"])((function (t) {
                        return o.cfgKeyNavigate(t)
                    }), ["prevent"])),
                    onClick: e[4] || (e[4] = Object(n["I"])((function (t) {
                        return o.cfgMouseNavigate(t)
                    }), ["prevent"])),
                    key: a
                }, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(t, (function (t, e) {
                    return Object(n["t"])(), Object(n["f"])("td", {
                        key: e,
                        tabindex: r.cfgGetTabIndex()
                    }, [Object(n["g"])("div", {
                        class: "div--left-align",
                        style: Object(n["p"])(o.cgfTDStyle(e)),
                        title: t,
                        fieldName: e
                    }, Object(n["B"])(t), 13, ni)], 8, ii)
                })), 128)), Object(n["g"])("td", {tabindex: r.cfgGetTabIndex()}, [Object(n["g"])("div", si, [Object(n["g"])("div", oi, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(i.pConfig.actionButtonHeader, (function (t) {
                    return Object(n["t"])(), Object(n["f"])("div", ri, [Object(n["i"])(l, {
                        onClick: function (e) {
                            return r.emitAction(e, t.emitAction)
                        },
                        heightButton: 22,
                        buttonType: 1,
                        title: t.tooltip,
                        style: Object(n["p"])(o.cfgIconColor(t.icon.color))
                    }, {
                        default: Object(n["G"])((function () {
                            return [Object(n["i"])(c, {
                                icon: r.cfgIconPictureAction(t.icon),
                                size: "1x"
                            }, null, 8, ["icon"])]
                        })), _: 2
                    }, 1032, ["onClick", "title", "style"])])
                })), 256))])])], 8, ai)], 40, ei)
            })), 128))], 512), ci], 512)], 512), Object(n["g"])("div", li, [i.pConfig.toolbar.show ? (Object(n["t"])(), Object(n["f"])("div", {
                key: 0,
                class: "toolbarButton",
                ref: this.REF_TOOLBAR
            }, [(Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(i.pConfig.toolbar.actionButton, (function (t) {
                return Object(n["t"])(), Object(n["f"])("div", di, [Object(n["i"])(l, {
                    onClick: function (e) {
                        return r.emitActionToolbar(e, t.emitAction)
                    },
                    heightButton: 22,
                    buttonType: 2,
                    title: t.tooltip,
                    style: Object(n["p"])(o.cfgIconColor(t.icon.color))
                }, {
                    default: Object(n["G"])((function () {
                        return [Object(n["i"])(c, {
                            icon: r.cfgIconPictureAction(t.icon),
                            size: "1x"
                        }, null, 8, ["icon"])]
                    })), _: 2
                }, 1032, ["onClick", "title", "style"])])
            })), 256)), Object(n["g"])("div", {
                class: "dataSelected",
                title: this.showSelectedData
            }, Object(n["B"])(this.showSelectedData), 9, ui)], 512)) : Object(n["e"])("", !0)]), Object(n["g"])("div", hi, [Object(n["g"])("div", fi, [Object(n["i"])(l, {
                onClick: e[5] || (e[5] = function (t) {
                    return r.goToPage(t, r.engine.paginate.buttonGoStart.id)
                }),
                ref: this.engine.paginate.buttonGoStart.ref,
                heightButton: 22,
                buttonType: 2,
                title: "goto first pagina"
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["i"])(c, {
                        icon: r.cfgIconPictureAction(r.engine.paginate.buttonGoStart.icon),
                        size: "1x"
                    }, null, 8, ["icon"])]
                })), _: 1
            }, 512)]), Object(n["g"])("div", gi, [Object(n["i"])(l, {
                onClick: e[6] || (e[6] = function (t) {
                    return r.goToPage(t, r.engine.paginate.buttonGoLeft.id)
                }), ref: this.engine.paginate.buttonGoLeft.ref, heightButton: 22, buttonType: 2, title: "previous page"
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["i"])(c, {
                        icon: r.cfgIconPictureAction(r.engine.paginate.buttonGoLeft.icon),
                        size: "1x"
                    }, null, 8, ["icon"])]
                })), _: 1
            }, 512)]), (Object(n["t"])(!0), Object(n["f"])(n["a"], null, Object(n["x"])(this.paginate.pag.buttons.bt, (function (t, e) {
                return Object(n["t"])(), Object(n["f"])(n["a"], {key: e}, [t.isDisable ? Object(n["e"])("", !0) : (Object(n["t"])(), Object(n["f"])("div", bi, [Object(n["i"])(l, {
                    class: Object(n["o"])({"ff-button-selected": t.selected}),
                    onClick: function (e) {
                        return r.goToPage(e, t.caption)
                    },
                    widthButton: 35,
                    heightButton: 22,
                    buttonType: 2,
                    title: r.privateGetPageTitle(t.caption)
                }, {
                    default: Object(n["G"])((function () {
                        return [Object(n["h"])(Object(n["B"])(t.caption), 1)]
                    })), _: 2
                }, 1032, ["class", "onClick", "title"])])), t.isDisable ? (Object(n["t"])(), Object(n["f"])("div", pi, mi)) : Object(n["e"])("", !0)], 64)
            })), 128)), Object(n["g"])("div", vi, [Object(n["i"])(l, {
                onClick: e[7] || (e[7] = function (t) {
                    return r.goToPage(t, r.engine.paginate.buttonGoRight.id)
                }), ref: this.engine.paginate.buttonGoRight.ref, heightButton: 22, buttonType: 2, title: "next page"
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["i"])(c, {
                        icon: r.cfgIconPictureAction(r.engine.paginate.buttonGoRight.icon),
                        size: "1x"
                    }, null, 8, ["icon"])]
                })), _: 1
            }, 512)]), Object(n["g"])("div", Ei, [Object(n["i"])(l, {
                onClick: e[8] || (e[8] = function (t) {
                    return r.goToPage(t, r.engine.paginate.buttonGoEnd.id)
                }), ref: this.engine.paginate.buttonGoEnd.ref, heightButton: 22, buttonType: 2, title: "goto last page"
            }, {
                default: Object(n["G"])((function () {
                    return [Object(n["i"])(c, {
                        icon: r.cfgIconPictureAction(r.engine.paginate.buttonGoEnd.icon),
                        size: "1x"
                    }, null, 8, ["icon"])]
                })), _: 1
            }, 512)]), Object(n["g"])("div", ji, [Object(n["i"])(l, {
                onClick: e[9] || (e[9] = function (t) {
                    return r.jumpPage(t)
                }), heightButton: 22, buttonType: 2, title: "goto number page"
            }, {
                default: Object(n["G"])((function () {
                    return [Ri]
                })), _: 1
            })]), Object(n["g"])("div", Ci, [Object(n["i"])(u, {
                ref: this.REF_INPUT_PAGE_NR,
                size: 1,
                pPlaceHolder: "nr. page",
                onKeyup: o.privateEnterGotoPage
            }, null, 8, ["pPlaceHolder", "onKeyup"])]), Object(n["g"])("div", {
                class: "divLabelInfo",
                title: this.privatePaginateTitleRecords()
            }, [Object(n["g"])("label", null, Object(n["B"])(this.paginate.pag.page) + "/" + Object(n["B"])(this.paginate.pag.total_pages), 1)], 8, yi)])], 512)
        }

        var Ti = i("b85c"), _i = (i("25f0"), i("fb6a"), {class: "ff-input-text"}),
            Di = ["id", "name", "minlength", "maxlength", "size", "placeholder"];

        function Ni(t, e, i, a, s, o) {
            return Object(n["t"])(), Object(n["f"])("div", _i, [Object(n["H"])(Object(n["g"])("input", {
                id: this.id,
                name: this.id,
                minlength: this.minlength,
                maxlength: this.maxlength,
                "onUpdate:modelValue": e[0] || (e[0] = function (t) {
                    return s.dataModel = t
                }),
                ref: "inputRef",
                size: this.size,
                placeholder: this.pPlaceHolder
            }, null, 8, Di), [[n["E"], s.dataModel]])])
        }

        var Ai = {
            name: "my-inputField",
            props: {
                id: String,
                maska: String,
                validate: Function,
                minlength: Number,
                maxlength: Number,
                size: Number,
                pPlaceHolder: {type: String, default: "input data ...", required: !1}
            },
            directives: {maska: oe["a"]},
            mounted: function () {
                this.vModelData = null
            },
            methods: {
                getValue: function () {
                    return this.dataModel
                }, setValue: function (t) {
                    this.dataModel = t
                }, keydownPress: function () {
                    event.target.id == this.id && console.log(this.getValue())
                }
            },
            data: function () {
                return {dataModel: null}
            }
        };
        const Si = g()(Ai, [["render", Ni]]);
        var Li = Si, Ii = {
            name: "grid-ul",
            components: {MyInputField: Li, "my-button": G, "page-nr-field": Li, "text-filter": Li},
            props: {pConfig: {type: Object, required: !0}},
            created: function () {
                this.REF_DIV_CONTAINER = "refDivContainer", this.REF_DIV_TABLE = "refDivTable", this.REF_TABLE = "refTable", this.REF_THEAD = "refThead", this.REF_TABLE_BODY = "refBody", this.REF_INPUT_PAGE_NR = "refPageNumber", this.REF_TOOLBAR = "refToolbar", this.KEY_PRESS_CONTROL_BROWSER = ["Tab", "Escape"], this.engine = {
                    tabIndexValue: 0,
                    tdCurent: null,
                    trCurent: null,
                    maximRows: 0,
                    CLASS_SELECTED: "selected",
                    CLASS_DINAMIC_BUTTON_PAG: "divButtonDinamic",
                    CLASS_PERMANENT_OVER: "ff-button-selected",
                    timeOut: null,
                    TIME_OUT_DELAY_FOR_FILTER: 600,
                    FILTER_MIN_CHARACTER: 2,
                    paginate: {
                        buttonGoStart: {
                            id: "b1",
                            icon: {fawIcon: "fas", icon: "angle-double-left", color: "darkred"},
                            ref: "refGoStart"
                        },
                        buttonGoLeft: {
                            id: "b2",
                            icon: {fawIcon: "fas", icon: "angle-left", color: "darkred"},
                            ref: "refGoLeft"
                        },
                        buttonGoRight: {
                            id: "b3",
                            icon: {fawIcon: "fas", icon: "angle-right", color: "darkred"},
                            ref: "refGoRight"
                        },
                        buttonGoEnd: {
                            id: "b4",
                            icon: {fawIcon: "fas", icon: "angle-double-right", color: "darkred"},
                            ref: "refGoEnd"
                        },
                        maxButtonPage: 5
                    }
                }, this.paginate.pag.buttons.bt = this.$vanilla.generateButton(this.pConfig.paginate.nrButtonShow)
            },
            beforeMount: function () {
                for (var t = !0, e = 0; e < this.pConfig.header.length; e++) {
                    if (this.pConfig.header[e].orderBy.order) {
                        var i = null;
                        this.pConfig.header[e].orderBy.defaultOrder && t && (i = this.$constGrid.ORDER_ASC, t = !1), this.orderBy.header.push(this.$constGrid.getOrderByReactive(this.pConfig.header[e].id, i, this.pConfig.header[e].tableFieldName)), this.pConfig.header[e].orderBy.defaultOrder && this.setOrderBy(this.pConfig.header[e].tableFieldName, i)
                    }
                    this.pConfig.header[e].filterBy && this.filterBy.header.push(this.$constGrid.getFilterByReactive(this.pConfig.header[e].id, this.pConfig.header[e].tableFieldName, null, !1, null, this.cfgIconColor("white")))
                }
            },
            mounted: function () {
                this.cfgGrid(), this.goToPage(null, "1");
                var t = this.$refs[this.REF_DIV_CONTAINER].parentNode, e = t.getBoundingClientRect();
                t.style.maxWidth = e.width + "px", t.style.maxHeight = e.height + "px"
            },
            computed: {},
            methods: {
                getDataFromServer: function (t) {
                    var e = this;
                    this.showModalLoadingDiv = !0;
                    var i = this.$url.getUrl(this.pConfig.cfg.urlData);
                    this.axios.post(i, this.post).then((function (t) {
                        e.showModalLoadingDiv = !0, e.paginate.totalRecords = t.data.paginate.records, e.rezultData = t.data.records
                    })).catch((function (t) {
                        return console.log(t)
                    })).finally((function () {
                        e.privateSetPaginatePag(1), e.$nextTick((function () {
                            this.initGrid()
                        })), e.privateSetPaginatePag(1), e.privateLoadAndDrawGrid(), e.showModalLoadingDiv = !1
                    }))
                }, refreshGrid: function (t, e) {
                    var i = "1";
                    this.$check.isUndef(t) || t == this.$constGrid.SQL_UPDATE && (i = this.paginate.pag.page.toString()), this.goToPage(null, i)
                }, getDataSelected: function () {
                    return this.selectdRow
                }, initGrid: function () {
                    this.engine.maximRows = this.paginate.pag.data.length, this.engine.maximRows > 0 && this.privateSelectedRow(this.$refs[this.REF_TABLE_BODY].rows[0])
                }, setFocusTD: function () {
                    this.engine.tdCurent.focus()
                }, resetSelectionRow: function () {
                    this.selectdRow = {}, this.showSelectedData = "", this.enabledToolBar(!1), this.privateRemoveSelectedRow()
                }, enabledToolBar: function (t) {
                    if (this.pConfig.toolbar.show) for (var e = this.$refs[this.REF_TOOLBAR].getElementsByTagName("button"), i = 0; i < e.length; i++) t ? this.$vanilla.enabledButton(e[i]) : this.$vanilla.disableButton(e[i])
                }, setOrderBy: function (t, e) {
                    this.post.orderBy.fieldName = t, this.post.orderBy.order = e
                }, privatePaginateTitleRecords: function () {
                    return "total records: " + this.paginate.pag.total
                }, privateGetHeaderColumn: function (t) {
                    var e = null, i = null;
                    if (isNaN(t)) e = t.target ? t.target.closest("th") : t.closest("th"), i = e.getAttribute("id"); else {
                        i = t;
                        for (var n = this.$refs[this.REF_THEAD].getElementsByTagName("th"), a = 0; a < n.length; a++) if (n[a].getAttribute("id") == i) {
                            e = n[a];
                            break
                        }
                    }
                    var s = e.getElementsByTagName("input")[0];
                    return {header: e, idHeader: i, filterByInput: s}
                }, privateReactiveShowFilterDiv: function (t) {
                    for (var e = !1, i = 0; i < this.filterBy.header.length; i++) if (this.filterBy.header[i].id == t) {
                        e = this.filterBy.header[i].showInputDiv;
                        break
                    }
                    return e
                }, privateShowMarkFilter: function (t) {
                    for (var e = this.cfgIconColor("white"), i = 0; i < this.filterBy.header.length; i++) if (!this.$check.isUndef(this.filterBy.header[i].filterString) && this.filterBy.header[i].id == t && this.filterBy.header[i].filterString.length > 0) {
                        e = this.cfgIconColor("brown"), this.filterBy.header[i].iconColor = e;
                        break
                    }
                    return e
                }, privateClearFilter: function (t) {
                    var e = this.privateGetHeaderColumn(t);
                    e.filterByInput.value = "", this.privateSetFilterValue(e.idHeader, "")
                }, privateShowFilterDiv: function (t) {
                    if (!this.showModalLoadingDiv) for (var e = this.privateGetHeaderColumn(t), i = 0; i < this.filterBy.header.length; i++) this.filterBy.header[i].id == e.idHeader ? this.filterBy.header[i].showInputDiv ? this.filterBy.header[i].showInputDiv = !1 : (this.filterBy.header[i].showInputDiv = !0, this.$nextTick((function () {
                        e.filterByInput.focus(), e.filterByInput.select()
                    }))) : this.filterBy.header[i].showInputDiv = !1
                }, privateKeyPresFilter: function (t) {
                    if (this.KEY_PRESS_CONTROL_BROWSER.includes(t.key)) ; else {
                        this.privateDelayFilterReset();
                        var e = t.target.value;
                        (e.length >= this.engine.FILTER_MIN_CHARACTER || e.length < this.engine.FILTER_MIN_CHARACTER) && this.privateDelayFilter(t.target)
                    }
                }, privateSetFilterValue: function (t, e, i) {
                    for (var n = 0; n < this.filterBy.header.length; n++) this.filterBy.header[n].id == t && this.filterBy.header[n].filterString != e && (this.filterBy.newFilter = !0, e.length < this.engine.FILTER_MIN_CHARACTER && (e = null), this.filterBy.header[n].filterString = e);
                    this.filterBy.newFilter && (this.post.filterBy = this.filterBy, this.goToPage(null, "1"))
                }, privateFilterBy: function (t) {
                    var e = this.privateGetHeaderColumn(t);
                    this.privateSetFilterValue(e.idHeader, e.filterByInput.value)
                }, privateDelayFilter: function (t) {
                    var e = this;
                    this.engine.timeOut = setTimeout((function () {
                        return e.privateFilterBy(t)
                    }), this.engine.TIME_OUT_DELAY_FOR_FILTER)
                }, privateDelayFilterReset: function () {
                    null != this.engine.timeOut && clearTimeout(this.engine.timeOut)
                }, privateOrderBy: function (t) {
                    if (!this.showModalLoadingDiv) {
                        var e = t.target.closest("div").firstChild.getAttribute("idheader"),
                            i = this.$vanilla.getAtributeValueFromArrayObject(this.orderBy.header, "id", e), n = null,
                            a = null;
                        this.$check.isUndef(i.order) ? n = this.$constGrid.ORDER_ASC : (n = this.$constGrid.ORDER_ASC, i.order == this.$constGrid.ORDER_ASC && (n = this.$constGrid.ORDER_DESC));
                        for (var s = 0; s < this.orderBy.header.length; s++) this.orderBy.header[s].order = null, this.orderBy.header[s].id == e && (this.orderBy.header[s].order = n, a = this.orderBy.header[s].fieldName);
                        this.setOrderBy(a, n), this.goToPage(null, this.post.paginate.pageNumber.toString())
                    }
                }, privateIconOrderBy: function (t) {
                    var e = this.$vanilla.getAtributeValueFromArrayObject(this.orderBy.header, "id", t), i = 0;
                    return e.order == this.$constGrid.ORDER_ASC ? i = 1 : e.order == this.$constGrid.ORDER_DESC && (i = 2), i
                }, privateLoadAndDrawGrid: function () {
                    this.privatedPageToolDraw(this.post.paginate.pageNumber), this.privateSetPaginatePag(this.post.paginate.pageNumber), this.privateCfgPaginateArrowButton()
                }, privateEnterGotoPage: function (t) {
                    "Enter" == t.key && this.jumpPage()
                }, privatedPageToolDraw: function (t) {
                    var e = this.paginate.pag.buttons.bt.length, i = parseInt(this.paginate.pag.buttons.bt[0].caption),
                        n = parseInt(this.paginate.pag.buttons.bt[e - 1].caption), a = t, s = !1;
                    (t > n || t < i) && (s = !0);
                    for (var o = 0; o < e; o++) {
                        s && (this.paginate.pag.buttons.bt[o].caption = a.toString(), a++);
                        var r = !1;
                        this.paginate.pag.buttons.bt[o].caption == t.toString() && (r = !0), this.paginate.pag.buttons.bt[o].selected = r;
                        var c = !1;
                        parseInt(this.paginate.pag.buttons.bt[o].caption) > this.paginate.pag.total_pages && (c = !0), this.paginate.pag.buttons.bt[o].isDisable = c
                    }
                }, jumpPage: function () {
                    var t = this.$refs[this.REF_INPUT_PAGE_NR], e = parseInt(t.getValue());
                    t.getValue() >= 1 && e <= this.paginate.pag.total_pages && this.goToPage(null, e.toString())
                }, goToPage: function (t, e) {
                    var i = null;
                    "b" == e.slice(0, 1) ? e == this.engine.paginate.buttonGoStart.id ? i = 1 : e == this.engine.paginate.buttonGoLeft.id ? i = this.paginate.pag.pre_page : e == this.engine.paginate.buttonGoRight.id ? i = this.paginate.pag.next_page : e == this.engine.paginate.buttonGoEnd.id && (i = this.paginate.pag.total_pages) : i = parseInt(e), this.post.paginate.pageNumber = i, this.post.paginate.perPage = this.pConfig.paginate.recordsPerPage, this.getDataFromServer("goToPage"), this.resetSelectionRow()
                }, privateSetPaginatePag: function (t) {
                    var e = this.$vanilla.paginateArray(this.rezultData, t, this.pConfig.paginate.recordsPerPage, !1, this.paginate.totalRecords);
                    this.paginate.pag.data = e.data, this.paginate.pag.next_page = e.next_page, this.paginate.pag.page = e.page, this.paginate.pag.pre_page = e.pre_page, this.paginate.pag.total = e.total, this.paginate.pag.total_pages = e.total_pages
                }, privateCfgPaginateArrowButton: function () {
                    var t = !1, e = !1;
                    1 == this.paginate.pag.page && (t = !0), this.paginate.pag.page != this.paginate.pag.total_pages && 0 != this.paginate.pag.total_pages || (e = !0), this.$refs[this.engine.paginate.buttonGoStart.ref].disable(t), this.$refs[this.engine.paginate.buttonGoLeft.ref].disable(t), this.$refs[this.engine.paginate.buttonGoEnd.ref].disable(e), this.$refs[this.engine.paginate.buttonGoRight.ref].disable(e)
                }, privateGetPageTitle: function (t) {
                    return "goto page " + t
                }, privateRemoveSelectedRow: function () {
                    this.$check.isUndef(this.engine.trCurent) || this.engine.trCurent.removeAttribute("class", this.engine.CLASS_SELECTED)
                }, privateSelectedRow: function (t) {
                    this.$check.isUndef(this.engine.trCurent) || this.engine.trCurent.removeAttribute("class", this.engine.CLASS_SELECTED), this.engine.trCurent = t, this.$check.isUndef(this.engine.tdCurent) ? this.engine.tdCurent = this.engine.trCurent.cells[0] : this.engine.tdCurent = this.engine.trCurent.cells[this.engine.tdCurent.cellIndex], this.engine.trCurent.setAttribute("class", this.engine.CLASS_SELECTED), this.privateGetDataFromTr()
                }, privateGetDataFromTr: function () {
                    var t = {};
                    t[this.$constGrid.ID_NAME] = this.engine.trCurent.getAttribute(this.$constGrid.ID_NAME);
                    var e, i = this.engine.trCurent.cells, n = Object(Ti["a"])(i);
                    try {
                        for (n.s(); !(e = n.n()).done;) {
                            var a = e.value, s = a.firstChild.getAttribute(this.$constGrid.BODY.FIELD_NAME);
                            this.pConfig.returnField.includes(s) && (t[s] = a.innerText)
                        }
                    } catch (o) {
                        n.e(o)
                    } finally {
                        n.f()
                    }
                    this.selectdRow = t, this.enabledToolBar(!0), this.privateMakeShowDataSelected()
                }, privateMakeShowDataSelected: function () {
                    if (this.pConfig.toolbar.show) {
                        var t, e = "", i = Object(Ti["a"])(this.pConfig.toolbar.fieldShow.field);
                        try {
                            for (i.s(); !(t = i.n()).done;) {
                                var n = t.value;
                                e += this.selectdRow[n] + this.pConfig.toolbar.fieldShow.separator
                            }
                        } catch (a) {
                            i.e(a)
                        } finally {
                            i.f()
                        }
                        this.pConfig.toolbar.fieldShow.includeIdPk && (e = "(" + this.selectdRow[this.$constGrid.ID_NAME] + ") " + e), this.showSelectedData = e
                    }
                }, privateSelectedCell: function (t) {
                    this.engine.tdCurent = t, this.setFocusTD()
                }, privateArrowDown: function () {
                    this.engine.trCurent.sectionRowIndex < this.paginate.pag.data.length - 1 && this.privateSelectedRow(this.engine.trCurent.nextSibling)
                }, privateArrowUp: function () {
                    this.engine.trCurent.sectionRowIndex > 0 && this.privateSelectedRow(this.engine.trCurent.previousSibling)
                }, privateArrowRight: function () {
                    this.$check.isUndef(this.engine.tdCurent.nextElementSibling) || this.privateSelectedCell(this.engine.tdCurent.nextElementSibling)
                }, privateArrowLeft: function () {
                    this.$check.isUndef(this.engine.tdCurent.previousElementSibling) || this.privateSelectedCell(this.engine.tdCurent.previousElementSibling)
                }, emitAction: function (t, e) {
                    this.cfgMouseNavigate(t), this.$emit(e, this.selectdRow)
                }, emitActionToolbar: function (t, e) {
                    this.pConfig.toolbar.show && this.$emit(e, this.getDataSelected())
                }, cfgGrid: function () {
                    var t = this.$refs[this.REF_DIV_TABLE], e = this.$refs[this.REF_THEAD].rows[0].cells;
                    this.cfgGridHeader(e);
                    var i = this.pConfig.cfg.width;
                    NaN != parseInt(i) && (i += "px"), t.style.width = i, t.style.height = this.pConfig.cfg.height + "px"
                }, cfgKeyNavigate: function (t) {
                    "ArrowRight" == t.key ? this.privateArrowRight() : "ArrowLeft" == t.key ? this.privateArrowLeft() : "ArrowDown" == t.key ? this.privateArrowDown() : "ArrowUp" == t.key ? this.privateArrowUp() : "Enter" == t.key || t.key
                }, cfgMouseNavigate: function (t) {
                    this.engine.tdCurent = t.target.closest("td"), this.privateSelectedRow(t.target.closest("tr"))
                }, cfgIconPictureAction: function (t) {
                    return [t.fawIcon, t.icon]
                }, cfgIconColor: function (t) {
                    return {color: t}
                }, cfgGridHeader: function (t) {
                    for (var e = 0; e < t.length; e++) {
                        var i = this.$vanilla.getAtributeValueFromArrayObject(this.pConfig.header, "id", t[e].getAttribute("id"), "width");
                        t[e].style.width = i + "px"
                    }
                }, cfgGetTabIndex: function () {
                    return this.engine.tabIndexValue++, this.engine.tabIndexValue
                }, cgfTDStyle: function (t) {
                    var e = this.$vanilla.getAtributeValueFromArrayObject(this.pConfig.header, this.$constGrid.HEADER.TABLE_FIELD_NAME, t, "width");
                    return {width: e + "px"}
                }
            },
            data: function () {
                return {
                    showModalLoadingDiv: !0,
                    rezultData: new Array,
                    selectdRow: {},
                    showSelectedData: "...",
                    paginate: {
                        totalRecords: 0,
                        buttonPageNumber: ["22", "23", "34", "45", "56", "68"],
                        pag: this.$vanilla.paginateArray(new Array)
                    },
                    orderBy: {header: new Array},
                    filterBy: {header: new Array, newFilter: !1},
                    post: {
                        paginate: {perPage: this.pConfig.paginate.recordsPerPage, pageNumber: 1, countRecords: -1},
                        orderBy: {fieldName: null, order: null},
                        filterBy: {header: new Array, newFilter: !1}
                    }
                }
            }
        };
        const Fi = g()(Ii, [["render", wi]]);
        var $i = Fi, ki = {class: "ff-form-modal", ref: "modalRef"}, Bi = ["id"],
            Mi = {class: "caption", ref: "captionRef"}, Pi = {class: "ff-form-table"}, xi = {class: "label bold"},
            Gi = ["for"], Ui = {class: "control"}, Hi = {class: "label bold"}, zi = ["for"], Wi = {class: "control"},
            Vi = Object(n["h"])("Update data"), Yi = Object(n["h"])("Delete data");

        function Ki(t, e, i, a, s, o) {
            var r = this, c = Object(n["z"])("validate-window"), l = Object(n["z"])("font-awesome-icon"),
                d = Object(n["z"])("test-field"), u = Object(n["z"])("button-send");
            return Object(n["t"])(), Object(n["f"])(n["a"], null, [Object(n["i"])(c, {
                ref: "validateWindowRef",
                cWidth: 500,
                cHeight: 200,
                cTypeWindows: 1
            }, null, 512), Object(n["i"])(c, {
                ref: "infoWindowRef",
                cWidth: 300,
                cHeight: 200,
                cTypeWindows: 5
            }, null, 512), Object(n["i"])(c, {
                ref: "redWindowRef",
                cWidth: 400,
                cHeight: 200,
                cTypeWindows: 6
            }, null, 512), Object(n["i"])(c, {
                ref: "refYesNo",
                cWidth: 300,
                cHeight: 200,
                cTypeWindows: 3,
                onEmitYesNoButton: o.emitYesNoButton
            }, null, 8, ["onEmitYesNoButton"]), Object(n["g"])("div", ki, [Object(n["g"])("div", {
                class: Object(n["o"])(s.formClass.container),
                ref: t.CONTAINER_REF,
                id: s.cfgForm.id
            }, [Object(n["g"])("div", {
                class: Object(n["o"])(s.formClass.header),
                ref: "headerRef"
            }, [Object(n["g"])("span", Mi, null, 512), Object(n["g"])("div", {
                class: "closeButton",
                onClick: e[0] || (e[0] = function () {
                    return o.closeForm && o.closeForm.apply(o, arguments)
                })
            }, [Object(n["i"])(l, {icon: s.cfgForm.closeIcon}, null, 8, ["icon"])])], 2), Object(n["g"])("div", {
                class: Object(n["o"])(s.formClass.content),
                ref: "contentRef"
            }, [Object(n["g"])("form", null, [Object(n["g"])("table", Pi, [Object(n["g"])("tr", null, [Object(n["g"])("td", xi, [Object(n["g"])("label", {for: t.NUME.id}, Object(n["B"])(t.NUME.caption), 9, Gi)]), Object(n["g"])("td", Ui, [Object(n["i"])(d, {
                id: t.NUME.id,
                ref: t.NUME.ref,
                maska: "",
                validate: t.NUME.validate,
                minlength: t.NUME.minLength,
                maxlength: t.NUME.maxLength,
                size: t.NUME.sizeField
            }, null, 8, ["id", "validate", "minlength", "maxlength", "size"])]), Object(n["g"])("td", Hi, [Object(n["g"])("label", {for: t.DESCRIERE.id}, Object(n["B"])(t.DESCRIERE.caption), 9, zi)]), Object(n["g"])("td", Wi, [Object(n["i"])(d, {
                id: t.DESCRIERE.id,
                ref: t.DESCRIERE.ref,
                maska: "",
                validate: t.DESCRIERE.validate,
                minlength: t.DESCRIERE.minLength,
                maxlength: t.DESCRIERE.maxLength,
                size: t.DESCRIERE.sizeField
            }, null, 8, ["id", "validate", "minlength", "maxlength", "size"])])])])])], 2), Object(n["g"])("div", {class: Object(n["o"])(s.formClass.button)}, [Object(n["g"])("div", {class: Object(n["o"])(s.formClass.buttonPozition)}, [Object(n["i"])(u, {
                onClick: e[1] || (e[1] = function (t) {
                    return o.sendData(r.$constGrid.SQL_UPDATE)
                })
            }, {
                default: Object(n["G"])((function () {
                    return [Vi]
                })), _: 1
            })], 2), Object(n["g"])("div", {class: Object(n["o"])(s.formClass.buttonPozition)}, [Object(n["i"])(u, {
                onClick: e[2] || (e[2] = function (t) {
                    return o.sendData(r.$constGrid.SQL_DELETE)
                })
            }, {
                default: Object(n["G"])((function () {
                    return [Yi]
                })), _: 1
            })], 2)], 2), Object(n["g"])("div", {class: Object(n["o"])(s.formClass.bottomLine)}, null, 2)], 10, Bi)], 512)], 64)
        }

        i("b0c0"), i("a4d3"), i("e01a");
        var qi = {
            components: {"test-field": Li, "check-box": ge, "button-send": G, "validate-window": kt},
            name: "grid-edit-test",
            created: function () {
                this.CONTAINER_REF = "containerRef", this.NUME = this.cfgNume(), this.DESCRIERE = this.cfgDescriere(), this.EMIT_UPDATEGRID = "emitUpdateGrid"
            },
            mounted: function () {
                this.configForm()
            },
            emits: ["emitUpdateGrid"],
            methods: {
                closeForm: function () {
                    this.$refs[this.CONTAINER_REF].style.display = "none", this.$refs.modalRef.style.display = "none"
                }, showForm: function (t, e) {
                    this.$refs.modalRef.style.display = "inline-block", this.$refs[this.CONTAINER_REF].style.display = "table", this.$check.isUndef(t) || this.$vanilla.centerDiv(t, this.$refs[this.CONTAINER_REF]), this.setPostData(e, null)
                }, setPostData: function (t, e) {
                    this.$check.isUndef(t) ? (this.post.name = this.$refs[this.NUME.ref].getValue(), this.post.description = this.$refs[this.DESCRIERE.ref].getValue(), this.post.actionType = e) : (this.post.id = t.idPk, this.post.name = t.name, this.post.description = t.description, this.post.actionType = e, this.$refs[this.NUME.ref].setValue(this.post.name), this.$refs[this.DESCRIERE.ref].setValue(this.post.description))
                }, cfgNume: function () {
                    var t = this.$app.cfgTextFIeld();
                    return t.setIdAndRef("nume"), t.minLength = 3, t.maxLength = 10, t.validate = this.validateNume, t.maska = "", t.caption = "Nume", t.mandatory = !1, t.sizeField = 10, t
                }, cfgDescriere: function () {
                    var t = this.$app.cfgTextFIeld();
                    return t.setIdAndRef("descriere"), t.minLength = 4, t.maxLength = 200, t.validate = this.validateDescriere, t.maska = "", t.caption = "Descriere", t.mandatory = !1, t.sizeField = 30, t
                }, configForm: function () {
                    this.cfgForm.id = "777TEST", this.cfgForm.closeIcon = ["fas", "times"], this.$refs.captionRef.innerHTML = "Introducere date de test", this.$vanilla.dragDiv(this.$refs.containerRef, this.$refs.headerRef)
                }, emitYesNoButton: function (t) {
                    1 == t ? (this.deleteYes = !0, this.sendData(this.$constGrid.SQL_DELETE)) : this.deleteYes = !1
                }, sendData: function (t) {
                    var e = this;
                    if (this.validateForm(), this.messageForm.length > 0 && t != this.$constGrid.SQL_DELETE) return this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate"), this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.messageForm)), this.$refs.validateWindowRef.show(), !1;
                    if (t != this.$constGrid.SQL_DELETE || this.deleteYes ? this.deleteYes = !0 : (this.$refs.refYesNo.setCaption("Delete"), this.$refs.refYesNo.setMessage("Datele sterse nu mai pot fi recuperate!"), this.$refs.refYesNo.show()), this.deleteYes) {
                        this.deleteYes = !1;
                        var i = this.$url.getUrl("gridDataTestUpdate");
                        this.setPostData(null, t), this.axios.post(i, this.post).then((function (i) {
                            i.data.succes ? (e.$emit(e.EMIT_UPDATEGRID, t, e.post), e.closeForm(), e.$refs.infoWindowRef.setCaption("Succes"), e.$refs.infoWindowRef.setMessage(e.$appServer.getHtmlSqlFormatMessage(i.data)), e.$refs.infoWindowRef.show()) : (e.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate"), e.$refs.validateWindowRef.setMessage(e.$appServer.getHtmlSqlFormatMessage(i.data)), e.$refs.validateWindowRef.show())
                        })).catch((function (t) {
                            e.$refs.redWindowRef.setCaption("Probleme ... "), e.$refs.redWindowRef.setMessage(t), e.$refs.redWindowRef.show()
                        }))
                    }
                }, validateForm: function () {
                    this.messageForm = [], this.$check.validateForm(this.$refs)
                }, validateNume: function () {
                    this.$check.lenghtMinMax(this.$refs[this.NUME.ref].getValue(), this.NUME.minLength, this.NUME.maxLength) || this.messageForm.push(this.$app.getFormMessageClass(this.NUME.id, this.NUME.caption, "trebuie sa aiba minim " + this.NUME.minLength + " si maxim " + this.NUME.maxLength + " caractere"))
                }, validateDescriere: function () {
                    var t = this.DESCRIERE;
                    this.$check.lenghtMinMax(this.$refs[t.ref].getValue(), t.minLength, t.maxLength) || this.messageForm.push(this.$app.getFormMessageClass(t.id, t.caption, "trebuie sa aiba minim " + t.minLength + " si maxim " + t.maxLength + " caractere"))
                }
            },
            data: function () {
                return {
                    formClass: this.$css.getCss("form"),
                    messageForm: [],
                    post: {},
                    cfgForm: {id: null, closeIcon: ["fas", "times"]},
                    deleteYes: !1
                }
            }
        };
        const Qi = g()(qi, [["render", Ki]]);
        var Zi = Qi, Xi = {
            name: "view-gridul",
            components: {"my-grid": $i, "my-button": G, "my-grid-edit": Zi},
            props: {},
            created: function () {
                this.gridConfig = {
                    header: [this.$constGrid.HEADER.getHeader(1, "idFiled", 30, "id", this.$constGrid.HEADER.CAPTION_TYPE_FIELD, !1, !1, !1), this.$constGrid.HEADER.getHeader(2, "Nume", 120, "name", this.$constGrid.HEADER.CAPTION_TYPE_FIELD, !0, !0, !0), this.$constGrid.HEADER.getHeader(3, "Descriere", 400, "description", this.$constGrid.HEADER.CAPTION_TYPE_FIELD, !0, !1, !0), this.$constGrid.HEADER.getHeader(6, "action", 50, null, this.$constGrid.HEADER.CAPTION_TYPE_ACTION, !1, !1, !1)],
                    actionButtonHeader: [this.$constGrid.getActionButton(8, "Print din functie", "invoicePrint", this.$constGrid.ICON_PRINT)],
                    returnField: ["name", "description"],
                    cfg: {width: 780, height: 350, urlData: "gridDataTest"},
                    toolbar: {
                        show: !0,
                        fieldShow: {field: ["name"], separator: " ", includeIdPk: !0},
                        actionButton: [this.$constGrid.getActionButton(null, "Edit din functie", "deleteCevaToolbar", this.$constGrid.ICON_DELETE), this.$constGrid.getActionButton(null, "Delete din functie", "editCevaToolbar", this.$constGrid.ICON_EDIT)]
                    },
                    paginate: {nrButtonShow: 5, recordsPerPage: 10}
                }
            },
            mounted: function () {
            },
            methods: {
                invoicePrint: function (t) {
                }, editCeva: function () {
                    console.log("editez ceva")
                }, deleteCevaToolbar: function (t) {
                    console.log("delete de la toolbar")
                }, editCevaToolbar: function (t) {
                    this.$refs.refGridEdit.showForm(this.$refs.refGridPrint, t, this.$constGrid.SQL_UPDATE)
                }, emitUpdateGrid: function (t, e) {
                    var i = null;
                    this.$refs.gridPrint.refreshGrid(t, i), console.log("date din grid au fost modificate = " + t, e)
                }
            },
            data: function () {
                return {}
            }
        };
        const Ji = g()(Xi, [["render", ze]]);
        var tn = Ji, en = [{path: "/", name: "Home", component: X}, {
                name: "TestControale",
                path: "/testControale",
                component: Ue
            }, {name: "Gridul", path: "/viewGridul", component: tn}],
            nn = Object(K["a"])({history: Object(K["b"])(), routes: en}), an = nn, sn = i("5502"),
            on = Object(sn["a"])({state: {}, mutations: {}, actions: {}, modules: {}}),
            rn = (i("7db0"), i("e9c4"), i("f628")), cn = i("8cac"), ln = i("b166"),
            dn = [{name: "login", url: "public/app/login"}, {name: "logout", url: "public/app/logout"}, {
                name: "test",
                url: "public/app/testResponse"
            }, {name: "invoicesList", url: "public/app/invoicesList"}, {
                name: "testInvoicesList",
                url: "public/app/testInvoicesList"
            }, {name: "invoicePrint", url: "public/app/invoicePrint"}, {
                name: "testInvoicePrint",
                url: "public/app/testInvoicePrint"
            }, {name: "partenersList", url: "public/app/partenersList"}, {
                name: "badmintonCourt",
                url: "public/app/badmintonCourt"
            }, {name: "addName", url: "public/app/addName"}, {
                name: "searchTest",
                url: "public/app/search"
            }, {name: "searchTableTest", url: "public/app/searchOnTable"}, {
                name: "gridDataTest",
                url: "public/app/gridDataTest"
            }, {name: "gridDataTestUpdate", url: "public/app/gridDataTestUpdate"}], un = [{
                name: "form",
                modal: "ff-form-modal",
                container: "ff-form",
                header: "form-header",
                content: "form-content",
                button: "form-button",
                buttonPozition: "buttons",
                bottomLine: "form-bottom-line"
            }], hn = {
                install: function (t, e) {
                    t.config.globalProperties.$url = {
                        appEnvGLP: Object({
                            NODE_ENV: "production",
                            VUE_APP_ENV: "host",
                            VUE_APP_URL_HOST: "https://www.finalf.badmintonclub.ro",
                            VUE_APP_URL_LOCAL: "https://finalf.badmintonclub.ro.mydev",
                            BASE_URL: "/"
                        }).APP_ENV,
                        vueEnv: "host",
                        urlAppHost: "https://www.finalf.badmintonclub.ro",
                        urlAppLocal: "https://finalf.badmintonclub.ro.mydev",
                        urlClientVue: "http://localhost:8080",
                        urlList: dn,
                        getUrl: function (t) {
                            var e = this.urlList.find((function (e) {
                                return e.name === t
                            }));
                            return void 0 === e ? "url for [" + t + "] not found" : this.getBaseUrl() + "/" + e.url
                        },
                        getBaseUrl: function () {
                            var t = this.urlAppLocal;
                            return t = "host" == this.vueEnv ? this.urlAppHost : "local" == this.vueEnv ? this.urlAppLocal : this.urlClientVue, t
                        }
                    }, t.config.globalProperties.$css = {
                        cssList: un, getCss: function (t) {
                            var e = this.cssList.find((function (e) {
                                return e.name === t
                            }));
                            return void 0 === e ? "css for [" + t + "] not found" : e
                        }
                    }, t.config.globalProperties.$vanilla = {
                        displayDivOnOff: function (t, e) {
                            var i = "off", n = "none";
                            return "none" !== t.style.display && "" !== t.style.display || (i = "on", n = e), t.style.display = n, i
                        }, disableButton: function (t) {
                            t.setAttribute("disabled", !0), t.classList.add("disable")
                        }, enabledButton: function (t) {
                            t.removeAttribute("disabled"), t.classList.remove("disable")
                        }, centerDiv: function (t, e) {
                            var i = t.getBoundingClientRect(), n = e.getBoundingClientRect(),
                                a = i.height / 2 - n.height / 2, s = i.width / 2 - n.width / 2;
                            e.style.top = a + "px", e.style.left = s + "px"
                        }, removeClasses: function (t, e) {
                            for (var i = 0; i < t.length; i++) t[i].classList.remove(e)
                        }, addClasses: function (t, e) {
                            for (var i = 0; i < t.length; i++) t[i].classList.add(e)
                        }, dragDiv: function (t, e) {
                            var i = 0, n = 0, a = 0, s = 0;

                            function o(t) {
                                t = t || window.event, t.preventDefault(), i = t.clientX - a, n = t.clientY - s, document.onmousemove = r, document.onmouseup = c
                            }

                            function r(e) {
                                e = e || window.event, e.preventDefault();
                                var o = e.clientX - i, r = e.clientY - n;
                                a = o, s = r, t.style.transform = "translate3d(" + o + "px, " + r + "px, 0)"
                            }

                            function c() {
                                document.onmouseup = null, document.onmousemove = null
                            }

                            e.onmousedown = o
                        }, getAtributeValueFromArrayObject: function (t, e, i, n) {
                            for (var a = null, s = 0; s < t.length; s++) if (t[s][e] == i) {
                                a = void 0 === n || null === n ? t[s] : t[s][n];
                                break
                            }
                            return a
                        }, generateButton: function (t) {
                            for (var e = new Array, i = 0; i < t; i++) e.push({
                                id: i,
                                caption: (i + 1).toString(),
                                selected: !1,
                                isDisable: !1
                            });
                            return e
                        }, paginateArray: function (t, e, i, n, a) {
                            e = e || 1, i = i || 10;
                            var s = (e - 1) * i, o = null, r = null, c = t.length;
                            return n ? (o = t.slice(s).slice(0, i), r = Math.ceil(c / i)) : (o = t, r = Math.ceil(a / i), c = a), {
                                page: e,
                                per_page: i,
                                pre_page: e - 1 ? e - 1 : null,
                                next_page: r > e ? e + 1 : null,
                                total: c,
                                total_pages: r,
                                data: o,
                                buttons: {
                                    label: null,
                                    intializeButtonPage: !1,
                                    bt: [{id: 0, caption: "1", selected: !1, isDisable: !1}, {
                                        id: 1,
                                        caption: "2",
                                        selected: !1,
                                        isDisable: !1
                                    }, {id: 2, caption: "3", selected: !1, isDisable: !1}, {
                                        id: 3,
                                        caption: "4",
                                        selected: !1,
                                        isDisable: !1
                                    }, {id: 4, caption: "5", selected: !1, isDisable: !1}, {
                                        id: 5,
                                        caption: "6",
                                        selected: !1,
                                        isDisable: !1
                                    }]
                                }
                            }
                        }
                    }, t.config.globalProperties.$startEndCurrentMonth = function () {
                        var t = "dd/MM/yyyy", e = new Date, i = Object(rn["a"])(e), n = Object(cn["a"])(e);
                        return {monthIn: Object(ln["a"])(i, t), monthSf: Object(ln["a"])(n, t)}
                    }, t.config.globalProperties.$check = {
                        isUndef: function (t) {
                            return void 0 === t || null === t
                        }, lenghtMinMax: function (t, e, i) {
                            var n = 0;
                            this.isUndef(t) || (n = t.length);
                            var a = parseInt(e), s = parseInt(i);
                            return NaN == a && (a = 0), NaN == s && (s = 0xfffffffffffff), n >= e && n <= i
                        }, validateForm: function (t) {
                            for (var e in t) "function" === typeof t[e].validate && t[e].validate()
                        }
                    }, t.config.globalProperties.$appServer = {
                        getHtmlSqlFormatMessage: function (t) {
                            var e = t.messages;
                            return t.admin && !t.succes && (e = e + "<br><br>" + t.errorMsg), e
                        }
                    }, t.config.globalProperties.$app = {
                        getObjectReturnComponent: function (t) {
                            return JSON.parse(JSON.stringify(t))
                        }, getFormMessageClass: function (t, e, i) {
                            return {field: t, caption: e, message: i}
                        }, getHtmlFormatMessage: function (t) {
                            for (var e = "", i = 0; i < t.length; i++) e = e + "<b>" + t[i].caption + ": &nbsp;</b>" + t[i].message + "<br>";
                            return e
                        }, cfgTextFIeld: function () {
                            return {
                                id: "",
                                minLength: 0,
                                maxLength: 0,
                                validate: "",
                                ref: "",
                                maska: "",
                                caption: "",
                                mandatory: !1,
                                sizeField: 0,
                                setIdAndRef: function (t) {
                                    this.id = t, this.ref = t + "Ref"
                                }
                            }
                        }, cfgCheckBox: function () {
                            return {
                                id: "",
                                ref: "",
                                validate: "",
                                caption: "",
                                defaultValue: !1,
                                disabled: !1,
                                setIdAndRef: function (t) {
                                    this.id = t, this.ref = t + "Ref"
                                }
                            }
                        }, cfgSelectSimple: function () {
                            return {
                                id: "",
                                ref: "",
                                validate: "",
                                mandatory: !1,
                                caption: "",
                                defaultValue: {id: 0, text: ""},
                                disabled: !1,
                                width: 0,
                                setIdAndRef: function (t) {
                                    this.id = t, this.ref = t + "Ref"
                                }
                            }
                        }
                    }
                }
            }, fn = hn, gn = {
                install: function (t, e) {
                    t.config.globalProperties.$constComponent = {ICON_SPINNER: ["fas", "spinner"]}, t.config.globalProperties.$constGrid = {
                        ID_NAME: "idPk",
                        ICON_CLASS: "fas",
                        ICON_PRINT: {fawIcon: "fas", icon: "print", color: "darkgreen"},
                        ICON_EDIT: {fawIcon: "fas", icon: "edit", color: "darkblue"},
                        ICON_DELETE: {fawIcon: "fas", icon: "times", color: "darkred"},
                        ICON_UP_ORDER: {fawIcon: "fas", icon: "caret-up", color: null},
                        ICON_DOWN_ORDER: {fawIcon: "fas", icon: "caret-down", color: null},
                        ICON_ORDER: {fawIcon: "fas", icon: "sort", color: null},
                        ICON_FILTER: {fawIcon: "fas", icon: "ellipsis-v", color: null},
                        ORDER_ASC: "asc",
                        ORDER_DESC: "desc",
                        SQL_UPDATE: "update",
                        SQL_UPDATE_DELETE: "updateDelete",
                        SQL_INSERT: "insert",
                        SQL_DELETE: "delete",
                        getIcon: function (t, e, i) {
                            return {fawIcon: t, icon: e, color: i}
                        },
                        HEADER: {
                            CAPTION_TYPE_FIELD: "field",
                            CAPTION_TYPE_ACTION: "action",
                            TABLE_FIELD_NAME: "tableFieldName",
                            getHeader: function (t, e, i, n, a, s, o, r) {
                                return a == this.CAPTION_TYPE_ACTION && (s = !1, o = !1, r = !1), s || (o = !1), {
                                    id: t,
                                    caption: e,
                                    width: i,
                                    tableFieldName: n,
                                    type: a,
                                    orderBy: {order: s, defaultOrder: o},
                                    filterBy: r
                                }
                            }
                        },
                        BODY: {FIELD_NAME: "fieldName"},
                        getActionButton: function (t, e, i, n) {
                            return {id: t, tooltip: e, emitAction: i, icon: n}
                        },
                        getOrderByReactive: function (t, e, i) {
                            return {id: t, order: e, fieldName: i}
                        },
                        getFilterByReactive: function (t, e, i, n, a, s) {
                            return {id: t, fieldName: e, filterString: i, showInputDiv: n, type: a, iconColor: s}
                        }
                    }
                }
            }, bn = gn, pn = i("130e"), On = i("bc3a"), mn = i.n(On), vn = i("ad3d"), En = i("ecee"), jn = i("c074"),
            Rn = i("f2d1"), Cn = i("b702");
        En["d"].add(jn["a"]), En["d"].add(Rn["a"]), En["d"].add(Cn["a"]), En["b"].watch();
        var yn = Object(n["c"])(Y);
        yn.component("font-awesome-icon", vn["a"]), yn.use(on).use(an), yn.use(bn), yn.use(fn), yn.use(pn["a"], mn.a), yn.mount("#app")
    }, "6f32": function (t, e, i) {
        var n = {
            "./angellist-brands.svg": "d931",
            "./apps_blue.svg": "4d20",
            "./shield-exclamation-yellow.svg": "f826"
        };

        function a(t) {
            var e = s(t);
            return i(e)
        }

        function s(t) {
            if (!i.o(n, t)) {
                var e = new Error("Cannot find module '" + t + "'");
                throw e.code = "MODULE_NOT_FOUND", e
            }
            return n[t]
        }

        a.keys = function () {
            return Object.keys(n)
        }, a.resolve = s, t.exports = a, a.id = "6f32"
    }, a01e: function (t, e, i) {
        "use strict";
        i("b830")
    }, b830: function (t, e, i) {
    }, d931: function (t, e, i) {
        t.exports = i.p + "img/angellist-brands.svg"
    }, f826: function (t, e, i) {
        t.exports = i.p + "img/shield-exclamation-yellow.svg"
    }
});
//# sourceMappingURL=app.js.map
