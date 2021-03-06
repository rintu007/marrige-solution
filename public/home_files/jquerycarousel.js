!function(e, t) {
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e);
    } : t(e);
}("undefined" != typeof window ? window : this, function(T, e) {
    var p = [], h = T.document, c = p.slice, m = p.concat, a = p.push, o = p.indexOf, n = {}, t = n.toString, v = n.hasOwnProperty, g = {}, i = "1.12.4", S = function(e, t) {
        return new S.fn.init(e, t);
    }, r = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, s = /^-ms-/, l = /-([\da-z])/gi, u = function(e, t) {
        return t.toUpperCase();
    };
    function d(e) {
        var t = !!e && "length" in e && e.length, n = S.type(e);
        return "function" !== n && !S.isWindow(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e);
    }
    S.fn = S.prototype = {
        jquery: i,
        constructor: S,
        selector: "",
        length: 0,
        toArray: function() {
            return c.call(this);
        },
        get: function(e) {
            return null != e ? e < 0 ? this[e + this.length] : this[e] : c.call(this);
        },
        pushStack: function(e) {
            var t = S.merge(this.constructor(), e);
            return t.prevObject = this, t.context = this.context, t;
        },
        each: function(e) {
            return S.each(this, e);
        },
        map: function(n) {
            return this.pushStack(S.map(this, function(e, t) {
                return n.call(e, t, e);
            }));
        },
        slice: function() {
            return this.pushStack(c.apply(this, arguments));
        },
        first: function() {
            return this.eq(0);
        },
        last: function() {
            return this.eq(-1);
        },
        eq: function(e) {
            var t = this.length, n = +e + (e < 0 ? t : 0);
            return this.pushStack(0 <= n && n < t ? [ this[n] ] : []);
        },
        end: function() {
            return this.prevObject || this.constructor();
        },
        push: a,
        sort: p.sort,
        splice: p.splice
    }, S.extend = S.fn.extend = function() {
        var e, t, n, i, o, r, s = arguments[0] || {}, a = 1, l = arguments.length, u = !1;
        for ("boolean" == typeof s && (u = s, s = arguments[a] || {}, a++), "object" == typeof s || S.isFunction(s) || (s = {}), 
        a === l && (s = this, a--); a < l; a++) if (null != (o = arguments[a])) for (i in o) e = s[i], 
        s !== (n = o[i]) && (u && n && (S.isPlainObject(n) || (t = S.isArray(n))) ? (t ? (t = !1, 
        r = e && S.isArray(e) ? e : []) : r = e && S.isPlainObject(e) ? e : {}, s[i] = S.extend(u, r, n)) : void 0 !== n && (s[i] = n));
        return s;
    }, S.extend({
        expando: "jQuery" + (i + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(e) {
            throw new Error(e);
        },
        noop: function() {},
        isFunction: function(e) {
            return "function" === S.type(e);
        },
        isArray: Array.isArray || function(e) {
            return "array" === S.type(e);
        },
        isWindow: function(e) {
            return null != e && e == e.window;
        },
        isNumeric: function(e) {
            var t = e && e.toString();
            return !S.isArray(e) && 0 <= t - parseFloat(t) + 1;
        },
        isEmptyObject: function(e) {
            var t;
            for (t in e) return !1;
            return !0;
        },
        isPlainObject: function(e) {
            var t;
            if (!e || "object" !== S.type(e) || e.nodeType || S.isWindow(e)) return !1;
            try {
                if (e.constructor && !v.call(e, "constructor") && !v.call(e.constructor.prototype, "isPrototypeOf")) return !1;
            } catch (e) {
                return !1;
            }
            if (!g.ownFirst) for (t in e) return v.call(e, t);
            for (t in e) ;
            return void 0 === t || v.call(e, t);
        },
        type: function(e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? n[t.call(e)] || "object" : typeof e;
        },
        globalEval: function(e) {
            e && S.trim(e) && (T.execScript || function(e) {
                T.eval.call(T, e);
            })(e);
        },
        camelCase: function(e) {
            return e.replace(s, "ms-").replace(l, u);
        },
        nodeName: function(e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase();
        },
        each: function(e, t) {
            var n, i = 0;
            if (d(e)) for (n = e.length; i < n && !1 !== t.call(e[i], i, e[i]); i++) ; else for (i in e) if (!1 === t.call(e[i], i, e[i])) break;
            return e;
        },
        trim: function(e) {
            return null == e ? "" : (e + "").replace(r, "");
        },
        makeArray: function(e, t) {
            var n = t || [];
            return null != e && (d(Object(e)) ? S.merge(n, "string" == typeof e ? [ e ] : e) : a.call(n, e)), 
            n;
        },
        inArray: function(e, t, n) {
            var i;
            if (t) {
                if (o) return o.call(t, e, n);
                for (i = t.length, n = n ? n < 0 ? Math.max(0, i + n) : n : 0; n < i; n++) if (n in t && t[n] === e) return n;
            }
            return -1;
        },
        merge: function(e, t) {
            for (var n = +t.length, i = 0, o = e.length; i < n; ) e[o++] = t[i++];
            if (n != n) for (;void 0 !== t[i]; ) e[o++] = t[i++];
            return e.length = o, e;
        },
        grep: function(e, t, n) {
            for (var i = [], o = 0, r = e.length, s = !n; o < r; o++) !t(e[o], o) !== s && i.push(e[o]);
            return i;
        },
        map: function(e, t, n) {
            var i, o, r = 0, s = [];
            if (d(e)) for (i = e.length; r < i; r++) null != (o = t(e[r], r, n)) && s.push(o); else for (r in e) null != (o = t(e[r], r, n)) && s.push(o);
            return m.apply([], s);
        },
        guid: 1,
        proxy: function(e, t) {
            var n, i, o;
            return "string" == typeof t && (o = e[t], t = e, e = o), S.isFunction(e) ? (n = c.call(arguments, 2), 
            (i = function() {
                return e.apply(t || this, n.concat(c.call(arguments)));
            }).guid = e.guid = e.guid || S.guid++, i) : void 0;
        },
        now: function() {
            return +new Date();
        },
        support: g
    }), "function" == typeof Symbol && (S.fn[Symbol.iterator] = p[Symbol.iterator]), 
    S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(e, t) {
        n["[object " + t + "]"] = t.toLowerCase();
    });
    var f = function(n) {
        var e, h, w, r, o, m, p, v, x, l, u, C, T, s, S, g, a, c, y, k = "sizzle" + 1 * new Date(), b = n.document, E = 0, i = 0, d = oe(), f = oe(), I = oe(), N = function(e, t) {
            return e === t && (u = !0), 0;
        }, A = {}.hasOwnProperty, t = [], D = t.pop, j = t.push, P = t.push, L = t.slice, $ = function(e, t) {
            for (var n = 0, i = e.length; n < i; n++) if (e[n] === t) return n;
            return -1;
        }, H = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped", q = "[\\x20\\t\\r\\n\\f]", W = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+", M = "\\[" + q + "*(" + W + ")(?:" + q + "*([*^$|!~]?=)" + q + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + W + "))|)" + q + "*\\]", O = ":(" + W + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + M + ")*)|.*)\\)|)", _ = new RegExp(q + "+", "g"), F = new RegExp("^" + q + "+|((?:^|[^\\\\])(?:\\\\.)*)" + q + "+$", "g"), R = new RegExp("^" + q + "*," + q + "*"), z = new RegExp("^" + q + "*([>+~]|" + q + ")" + q + "*"), B = new RegExp("=" + q + "*([^\\]'\"]*?)" + q + "*\\]", "g"), X = new RegExp(O), V = new RegExp("^" + W + "$"), U = {
            ID: new RegExp("^#(" + W + ")"),
            CLASS: new RegExp("^\\.(" + W + ")"),
            TAG: new RegExp("^(" + W + "|[*])"),
            ATTR: new RegExp("^" + M),
            PSEUDO: new RegExp("^" + O),
            CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + q + "*(even|odd|(([+-]|)(\\d*)n|)" + q + "*(?:([+-]|)" + q + "*(\\d+)|))" + q + "*\\)|)", "i"),
            bool: new RegExp("^(?:" + H + ")$", "i"),
            needsContext: new RegExp("^" + q + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + q + "*((?:-\\d)?\\d*)" + q + "*\\)|)(?=[^-]|$)", "i")
        }, Y = /^(?:input|select|textarea|button)$/i, G = /^h\d$/i, J = /^[^{]+\{\s*\[native \w/, Q = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, K = /[+~]/, Z = /'|\\/g, ee = new RegExp("\\\\([\\da-f]{1,6}" + q + "?|(" + q + ")|.)", "ig"), te = function(e, t, n) {
            var i = "0x" + t - 65536;
            return i != i || n ? t : i < 0 ? String.fromCharCode(i + 65536) : String.fromCharCode(i >> 10 | 55296, 1023 & i | 56320);
        }, ne = function() {
            C();
        };
        try {
            P.apply(t = L.call(b.childNodes), b.childNodes), t[b.childNodes.length].nodeType;
        } catch (e) {
            P = {
                apply: t.length ? function(e, t) {
                    j.apply(e, L.call(t));
                } : function(e, t) {
                    for (var n = e.length, i = 0; e[n++] = t[i++]; ) ;
                    e.length = n - 1;
                }
            };
        }
        function ie(e, t, n, i) {
            var o, r, s, a, l, u, c, p, d = t && t.ownerDocument, f = t ? t.nodeType : 9;
            if (n = n || [], "string" != typeof e || !e || 1 !== f && 9 !== f && 11 !== f) return n;
            if (!i && ((t ? t.ownerDocument || t : b) !== T && C(t), t = t || T, S)) {
                if (11 !== f && (u = Q.exec(e))) if (o = u[1]) {
                    if (9 === f) {
                        if (!(s = t.getElementById(o))) return n;
                        if (s.id === o) return n.push(s), n;
                    } else if (d && (s = d.getElementById(o)) && y(t, s) && s.id === o) return n.push(s), 
                    n;
                } else {
                    if (u[2]) return P.apply(n, t.getElementsByTagName(e)), n;
                    if ((o = u[3]) && h.getElementsByClassName && t.getElementsByClassName) return P.apply(n, t.getElementsByClassName(o)), 
                    n;
                }
                if (h.qsa && !I[e + " "] && (!g || !g.test(e))) {
                    if (1 !== f) d = t, p = e; else if ("object" !== t.nodeName.toLowerCase()) {
                        for ((a = t.getAttribute("id")) ? a = a.replace(Z, "\\$&") : t.setAttribute("id", a = k), 
                        r = (c = m(e)).length, l = V.test(a) ? "#" + a : "[id='" + a + "']"; r--; ) c[r] = l + " " + he(c[r]);
                        p = c.join(","), d = K.test(e) && de(t.parentNode) || t;
                    }
                    if (p) try {
                        return P.apply(n, d.querySelectorAll(p)), n;
                    } catch (e) {} finally {
                        a === k && t.removeAttribute("id");
                    }
                }
            }
            return v(e.replace(F, "$1"), t, n, i);
        }
        function oe() {
            var i = [];
            return function e(t, n) {
                return i.push(t + " ") > w.cacheLength && delete e[i.shift()], e[t + " "] = n;
            };
        }
        function re(e) {
            return e[k] = !0, e;
        }
        function se(e) {
            var t = T.createElement("div");
            try {
                return !!e(t);
            } catch (e) {
                return !1;
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null;
            }
        }
        function ae(e, t) {
            for (var n = e.split("|"), i = n.length; i--; ) w.attrHandle[n[i]] = t;
        }
        function le(e, t) {
            var n = t && e, i = n && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || 1 << 31) - (~e.sourceIndex || 1 << 31);
            if (i) return i;
            if (n) for (;n = n.nextSibling; ) if (n === t) return -1;
            return e ? 1 : -1;
        }
        function ue(t) {
            return function(e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t;
            };
        }
        function ce(n) {
            return function(e) {
                var t = e.nodeName.toLowerCase();
                return ("input" === t || "button" === t) && e.type === n;
            };
        }
        function pe(s) {
            return re(function(r) {
                return r = +r, re(function(e, t) {
                    for (var n, i = s([], e.length, r), o = i.length; o--; ) e[n = i[o]] && (e[n] = !(t[n] = e[n]));
                });
            });
        }
        function de(e) {
            return e && void 0 !== e.getElementsByTagName && e;
        }
        for (e in h = ie.support = {}, o = ie.isXML = function(e) {
            var t = e && (e.ownerDocument || e).documentElement;
            return !!t && "HTML" !== t.nodeName;
        }, C = ie.setDocument = function(e) {
            var t, n, i = e ? e.ownerDocument || e : b;
            return i !== T && 9 === i.nodeType && i.documentElement && (s = (T = i).documentElement, 
            S = !o(T), (n = T.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", ne, !1) : n.attachEvent && n.attachEvent("onunload", ne)), 
            h.attributes = se(function(e) {
                return e.className = "i", !e.getAttribute("className");
            }), h.getElementsByTagName = se(function(e) {
                return e.appendChild(T.createComment("")), !e.getElementsByTagName("*").length;
            }), h.getElementsByClassName = J.test(T.getElementsByClassName), h.getById = se(function(e) {
                return s.appendChild(e).id = k, !T.getElementsByName || !T.getElementsByName(k).length;
            }), h.getById ? (w.find.ID = function(e, t) {
                if (void 0 !== t.getElementById && S) {
                    var n = t.getElementById(e);
                    return n ? [ n ] : [];
                }
            }, w.filter.ID = function(e) {
                var t = e.replace(ee, te);
                return function(e) {
                    return e.getAttribute("id") === t;
                };
            }) : (delete w.find.ID, w.filter.ID = function(e) {
                var n = e.replace(ee, te);
                return function(e) {
                    var t = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                    return t && t.value === n;
                };
            }), w.find.TAG = h.getElementsByTagName ? function(e, t) {
                return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : h.qsa ? t.querySelectorAll(e) : void 0;
            } : function(e, t) {
                var n, i = [], o = 0, r = t.getElementsByTagName(e);
                if ("*" === e) {
                    for (;n = r[o++]; ) 1 === n.nodeType && i.push(n);
                    return i;
                }
                return r;
            }, w.find.CLASS = h.getElementsByClassName && function(e, t) {
                return void 0 !== t.getElementsByClassName && S ? t.getElementsByClassName(e) : void 0;
            }, a = [], g = [], (h.qsa = J.test(T.querySelectorAll)) && (se(function(e) {
                s.appendChild(e).innerHTML = "<a id='" + k + "'></a><select id='" + k + "-\r\\' msallowcapture=''><option selected=''></option></select>", 
                e.querySelectorAll("[msallowcapture^='']").length && g.push("[*^$]=" + q + "*(?:''|\"\")"), 
                e.querySelectorAll("[selected]").length || g.push("\\[" + q + "*(?:value|" + H + ")"), 
                e.querySelectorAll("[id~=" + k + "-]").length || g.push("~="), e.querySelectorAll(":checked").length || g.push(":checked"), 
                e.querySelectorAll("a#" + k + "+*").length || g.push(".#.+[+~]");
            }), se(function(e) {
                var t = T.createElement("input");
                t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && g.push("name" + q + "*[*^$|!~]?="), 
                e.querySelectorAll(":enabled").length || g.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), 
                g.push(",.*:");
            })), (h.matchesSelector = J.test(c = s.matches || s.webkitMatchesSelector || s.mozMatchesSelector || s.oMatchesSelector || s.msMatchesSelector)) && se(function(e) {
                h.disconnectedMatch = c.call(e, "div"), c.call(e, "[s!='']:x"), a.push("!=", O);
            }), g = g.length && new RegExp(g.join("|")), a = a.length && new RegExp(a.join("|")), 
            t = J.test(s.compareDocumentPosition), y = t || J.test(s.contains) ? function(e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, i = t && t.parentNode;
                return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)));
            } : function(e, t) {
                if (t) for (;t = t.parentNode; ) if (t === e) return !0;
                return !1;
            }, N = t ? function(e, t) {
                if (e === t) return u = !0, 0;
                var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
                return n || (1 & (n = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !h.sortDetached && t.compareDocumentPosition(e) === n ? e === T || e.ownerDocument === b && y(b, e) ? -1 : t === T || t.ownerDocument === b && y(b, t) ? 1 : l ? $(l, e) - $(l, t) : 0 : 4 & n ? -1 : 1);
            } : function(e, t) {
                if (e === t) return u = !0, 0;
                var n, i = 0, o = e.parentNode, r = t.parentNode, s = [ e ], a = [ t ];
                if (!o || !r) return e === T ? -1 : t === T ? 1 : o ? -1 : r ? 1 : l ? $(l, e) - $(l, t) : 0;
                if (o === r) return le(e, t);
                for (n = e; n = n.parentNode; ) s.unshift(n);
                for (n = t; n = n.parentNode; ) a.unshift(n);
                for (;s[i] === a[i]; ) i++;
                return i ? le(s[i], a[i]) : s[i] === b ? -1 : a[i] === b ? 1 : 0;
            }), T;
        }, ie.matches = function(e, t) {
            return ie(e, null, null, t);
        }, ie.matchesSelector = function(e, t) {
            if ((e.ownerDocument || e) !== T && C(e), t = t.replace(B, "='$1']"), h.matchesSelector && S && !I[t + " "] && (!a || !a.test(t)) && (!g || !g.test(t))) try {
                var n = c.call(e, t);
                if (n || h.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n;
            } catch (e) {}
            return 0 < ie(t, T, null, [ e ]).length;
        }, ie.contains = function(e, t) {
            return (e.ownerDocument || e) !== T && C(e), y(e, t);
        }, ie.attr = function(e, t) {
            (e.ownerDocument || e) !== T && C(e);
            var n = w.attrHandle[t.toLowerCase()], i = n && A.call(w.attrHandle, t.toLowerCase()) ? n(e, t, !S) : void 0;
            return void 0 !== i ? i : h.attributes || !S ? e.getAttribute(t) : (i = e.getAttributeNode(t)) && i.specified ? i.value : null;
        }, ie.error = function(e) {
            throw new Error("Syntax error, unrecognized expression: " + e);
        }, ie.uniqueSort = function(e) {
            var t, n = [], i = 0, o = 0;
            if (u = !h.detectDuplicates, l = !h.sortStable && e.slice(0), e.sort(N), u) {
                for (;t = e[o++]; ) t === e[o] && (i = n.push(o));
                for (;i--; ) e.splice(n[i], 1);
            }
            return l = null, e;
        }, r = ie.getText = function(e) {
            var t, n = "", i = 0, o = e.nodeType;
            if (o) {
                if (1 === o || 9 === o || 11 === o) {
                    if ("string" == typeof e.textContent) return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling) n += r(e);
                } else if (3 === o || 4 === o) return e.nodeValue;
            } else for (;t = e[i++]; ) n += r(t);
            return n;
        }, (w = ie.selectors = {
            cacheLength: 50,
            createPseudo: re,
            match: U,
            attrHandle: {},
            find: {},
            relative: {
                ">": {
                    dir: "parentNode",
                    first: !0
                },
                " ": {
                    dir: "parentNode"
                },
                "+": {
                    dir: "previousSibling",
                    first: !0
                },
                "~": {
                    dir: "previousSibling"
                }
            },
            preFilter: {
                ATTR: function(e) {
                    return e[1] = e[1].replace(ee, te), e[3] = (e[3] || e[4] || e[5] || "").replace(ee, te), 
                    "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4);
                },
                CHILD: function(e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || ie.error(e[0]), 
                    e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && ie.error(e[0]), 
                    e;
                },
                PSEUDO: function(e) {
                    var t, n = !e[6] && e[2];
                    return U.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && X.test(n) && (t = m(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), 
                    e[2] = n.slice(0, t)), e.slice(0, 3));
                }
            },
            filter: {
                TAG: function(e) {
                    var t = e.replace(ee, te).toLowerCase();
                    return "*" === e ? function() {
                        return !0;
                    } : function(e) {
                        return e.nodeName && e.nodeName.toLowerCase() === t;
                    };
                },
                CLASS: function(e) {
                    var t = d[e + " "];
                    return t || (t = new RegExp("(^|" + q + ")" + e + "(" + q + "|$)")) && d(e, function(e) {
                        return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "");
                    });
                },
                ATTR: function(n, i, o) {
                    return function(e) {
                        var t = ie.attr(e, n);
                        return null == t ? "!=" === i : !i || (t += "", "=" === i ? t === o : "!=" === i ? t !== o : "^=" === i ? o && 0 === t.indexOf(o) : "*=" === i ? o && -1 < t.indexOf(o) : "$=" === i ? o && t.slice(-o.length) === o : "~=" === i ? -1 < (" " + t.replace(_, " ") + " ").indexOf(o) : "|=" === i && (t === o || t.slice(0, o.length + 1) === o + "-"));
                    };
                },
                CHILD: function(h, e, t, m, v) {
                    var g = "nth" !== h.slice(0, 3), y = "last" !== h.slice(-4), b = "of-type" === e;
                    return 1 === m && 0 === v ? function(e) {
                        return !!e.parentNode;
                    } : function(e, t, n) {
                        var i, o, r, s, a, l, u = g !== y ? "nextSibling" : "previousSibling", c = e.parentNode, p = b && e.nodeName.toLowerCase(), d = !n && !b, f = !1;
                        if (c) {
                            if (g) {
                                for (;u; ) {
                                    for (s = e; s = s[u]; ) if (b ? s.nodeName.toLowerCase() === p : 1 === s.nodeType) return !1;
                                    l = u = "only" === h && !l && "nextSibling";
                                }
                                return !0;
                            }
                            if (l = [ y ? c.firstChild : c.lastChild ], y && d) {
                                for (f = (a = (i = (o = (r = (s = c)[k] || (s[k] = {}))[s.uniqueID] || (r[s.uniqueID] = {}))[h] || [])[0] === E && i[1]) && i[2], 
                                s = a && c.childNodes[a]; s = ++a && s && s[u] || (f = a = 0) || l.pop(); ) if (1 === s.nodeType && ++f && s === e) {
                                    o[h] = [ E, a, f ];
                                    break;
                                }
                            } else if (d && (f = a = (i = (o = (r = (s = e)[k] || (s[k] = {}))[s.uniqueID] || (r[s.uniqueID] = {}))[h] || [])[0] === E && i[1]), 
                            !1 === f) for (;(s = ++a && s && s[u] || (f = a = 0) || l.pop()) && ((b ? s.nodeName.toLowerCase() !== p : 1 !== s.nodeType) || !++f || (d && ((o = (r = s[k] || (s[k] = {}))[s.uniqueID] || (r[s.uniqueID] = {}))[h] = [ E, f ]), 
                            s !== e)); ) ;
                            return (f -= v) === m || f % m == 0 && 0 <= f / m;
                        }
                    };
                },
                PSEUDO: function(e, r) {
                    var t, s = w.pseudos[e] || w.setFilters[e.toLowerCase()] || ie.error("unsupported pseudo: " + e);
                    return s[k] ? s(r) : 1 < s.length ? (t = [ e, e, "", r ], w.setFilters.hasOwnProperty(e.toLowerCase()) ? re(function(e, t) {
                        for (var n, i = s(e, r), o = i.length; o--; ) e[n = $(e, i[o])] = !(t[n] = i[o]);
                    }) : function(e) {
                        return s(e, 0, t);
                    }) : s;
                }
            },
            pseudos: {
                not: re(function(e) {
                    var i = [], o = [], a = p(e.replace(F, "$1"));
                    return a[k] ? re(function(e, t, n, i) {
                        for (var o, r = a(e, null, i, []), s = e.length; s--; ) (o = r[s]) && (e[s] = !(t[s] = o));
                    }) : function(e, t, n) {
                        return i[0] = e, a(i, null, n, o), i[0] = null, !o.pop();
                    };
                }),
                has: re(function(t) {
                    return function(e) {
                        return 0 < ie(t, e).length;
                    };
                }),
                contains: re(function(t) {
                    return t = t.replace(ee, te), function(e) {
                        return -1 < (e.textContent || e.innerText || r(e)).indexOf(t);
                    };
                }),
                lang: re(function(n) {
                    return V.test(n || "") || ie.error("unsupported lang: " + n), n = n.replace(ee, te).toLowerCase(), 
                    function(e) {
                        var t;
                        do {
                            if (t = S ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n + "-");
                        } while ((e = e.parentNode) && 1 === e.nodeType);
                        return !1;
                    };
                }),
                target: function(e) {
                    var t = n.location && n.location.hash;
                    return t && t.slice(1) === e.id;
                },
                root: function(e) {
                    return e === s;
                },
                focus: function(e) {
                    return e === T.activeElement && (!T.hasFocus || T.hasFocus()) && !!(e.type || e.href || ~e.tabIndex);
                },
                enabled: function(e) {
                    return !1 === e.disabled;
                },
                disabled: function(e) {
                    return !0 === e.disabled;
                },
                checked: function(e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected;
                },
                selected: function(e) {
                    return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected;
                },
                empty: function(e) {
                    for (e = e.firstChild; e; e = e.nextSibling) if (e.nodeType < 6) return !1;
                    return !0;
                },
                parent: function(e) {
                    return !w.pseudos.empty(e);
                },
                header: function(e) {
                    return G.test(e.nodeName);
                },
                input: function(e) {
                    return Y.test(e.nodeName);
                },
                button: function(e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t;
                },
                text: function(e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase());
                },
                first: pe(function() {
                    return [ 0 ];
                }),
                last: pe(function(e, t) {
                    return [ t - 1 ];
                }),
                eq: pe(function(e, t, n) {
                    return [ n < 0 ? n + t : n ];
                }),
                even: pe(function(e, t) {
                    for (var n = 0; n < t; n += 2) e.push(n);
                    return e;
                }),
                odd: pe(function(e, t) {
                    for (var n = 1; n < t; n += 2) e.push(n);
                    return e;
                }),
                lt: pe(function(e, t, n) {
                    for (var i = n < 0 ? n + t : n; 0 <= --i; ) e.push(i);
                    return e;
                }),
                gt: pe(function(e, t, n) {
                    for (var i = n < 0 ? n + t : n; ++i < t; ) e.push(i);
                    return e;
                })
            }
        }).pseudos.nth = w.pseudos.eq, {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) w.pseudos[e] = ue(e);
        for (e in {
            submit: !0,
            reset: !0
        }) w.pseudos[e] = ce(e);
        function fe() {}
        function he(e) {
            for (var t = 0, n = e.length, i = ""; t < n; t++) i += e[t].value;
            return i;
        }
        function me(a, e, t) {
            var l = e.dir, u = t && "parentNode" === l, c = i++;
            return e.first ? function(e, t, n) {
                for (;e = e[l]; ) if (1 === e.nodeType || u) return a(e, t, n);
            } : function(e, t, n) {
                var i, o, r, s = [ E, c ];
                if (n) {
                    for (;e = e[l]; ) if ((1 === e.nodeType || u) && a(e, t, n)) return !0;
                } else for (;e = e[l]; ) if (1 === e.nodeType || u) {
                    if ((i = (o = (r = e[k] || (e[k] = {}))[e.uniqueID] || (r[e.uniqueID] = {}))[l]) && i[0] === E && i[1] === c) return s[2] = i[2];
                    if ((o[l] = s)[2] = a(e, t, n)) return !0;
                }
            };
        }
        function ve(o) {
            return 1 < o.length ? function(e, t, n) {
                for (var i = o.length; i--; ) if (!o[i](e, t, n)) return !1;
                return !0;
            } : o[0];
        }
        function ge(e, t, n, i, o) {
            for (var r, s = [], a = 0, l = e.length, u = null != t; a < l; a++) (r = e[a]) && (n && !n(r, i, o) || (s.push(r), 
            u && t.push(a)));
            return s;
        }
        function ye(f, h, m, v, g, e) {
            return v && !v[k] && (v = ye(v)), g && !g[k] && (g = ye(g, e)), re(function(e, t, n, i) {
                var o, r, s, a = [], l = [], u = t.length, c = e || function(e, t, n) {
                    for (var i = 0, o = t.length; i < o; i++) ie(e, t[i], n);
                    return n;
                }(h || "*", n.nodeType ? [ n ] : n, []), p = !f || !e && h ? c : ge(c, a, f, n, i), d = m ? g || (e ? f : u || v) ? [] : t : p;
                if (m && m(p, d, n, i), v) for (o = ge(d, l), v(o, [], n, i), r = o.length; r--; ) (s = o[r]) && (d[l[r]] = !(p[l[r]] = s));
                if (e) {
                    if (g || f) {
                        if (g) {
                            for (o = [], r = d.length; r--; ) (s = d[r]) && o.push(p[r] = s);
                            g(null, d = [], o, i);
                        }
                        for (r = d.length; r--; ) (s = d[r]) && -1 < (o = g ? $(e, s) : a[r]) && (e[o] = !(t[o] = s));
                    }
                } else d = ge(d === t ? d.splice(u, d.length) : d), g ? g(null, t, d, i) : P.apply(t, d);
            });
        }
        function be(e) {
            for (var o, t, n, i = e.length, r = w.relative[e[0].type], s = r || w.relative[" "], a = r ? 1 : 0, l = me(function(e) {
                return e === o;
            }, s, !0), u = me(function(e) {
                return -1 < $(o, e);
            }, s, !0), c = [ function(e, t, n) {
                var i = !r && (n || t !== x) || ((o = t).nodeType ? l(e, t, n) : u(e, t, n));
                return o = null, i;
            } ]; a < i; a++) if (t = w.relative[e[a].type]) c = [ me(ve(c), t) ]; else {
                if ((t = w.filter[e[a].type].apply(null, e[a].matches))[k]) {
                    for (n = ++a; n < i && !w.relative[e[n].type]; n++) ;
                    return ye(1 < a && ve(c), 1 < a && he(e.slice(0, a - 1).concat({
                        value: " " === e[a - 2].type ? "*" : ""
                    })).replace(F, "$1"), t, a < n && be(e.slice(a, n)), n < i && be(e = e.slice(n)), n < i && he(e));
                }
                c.push(t);
            }
            return ve(c);
        }
        return fe.prototype = w.filters = w.pseudos, w.setFilters = new fe(), m = ie.tokenize = function(e, t) {
            var n, i, o, r, s, a, l, u = f[e + " "];
            if (u) return t ? 0 : u.slice(0);
            for (s = e, a = [], l = w.preFilter; s; ) {
                for (r in n && !(i = R.exec(s)) || (i && (s = s.slice(i[0].length) || s), a.push(o = [])), 
                n = !1, (i = z.exec(s)) && (n = i.shift(), o.push({
                    value: n,
                    type: i[0].replace(F, " ")
                }), s = s.slice(n.length)), w.filter) !(i = U[r].exec(s)) || l[r] && !(i = l[r](i)) || (n = i.shift(), 
                o.push({
                    value: n,
                    type: r,
                    matches: i
                }), s = s.slice(n.length));
                if (!n) break;
            }
            return t ? s.length : s ? ie.error(e) : f(e, a).slice(0);
        }, p = ie.compile = function(e, t) {
            var n, v, g, y, b, i, o = [], r = [], s = I[e + " "];
            if (!s) {
                for (t || (t = m(e)), n = t.length; n--; ) (s = be(t[n]))[k] ? o.push(s) : r.push(s);
                (s = I(e, (v = r, y = 0 < (g = o).length, b = 0 < v.length, i = function(e, t, n, i, o) {
                    var r, s, a, l = 0, u = "0", c = e && [], p = [], d = x, f = e || b && w.find.TAG("*", o), h = E += null == d ? 1 : Math.random() || .1, m = f.length;
                    for (o && (x = t === T || t || o); u !== m && null != (r = f[u]); u++) {
                        if (b && r) {
                            for (s = 0, t || r.ownerDocument === T || (C(r), n = !S); a = v[s++]; ) if (a(r, t || T, n)) {
                                i.push(r);
                                break;
                            }
                            o && (E = h);
                        }
                        y && ((r = !a && r) && l--, e && c.push(r));
                    }
                    if (l += u, y && u !== l) {
                        for (s = 0; a = g[s++]; ) a(c, p, t, n);
                        if (e) {
                            if (0 < l) for (;u--; ) c[u] || p[u] || (p[u] = D.call(i));
                            p = ge(p);
                        }
                        P.apply(i, p), o && !e && 0 < p.length && 1 < l + g.length && ie.uniqueSort(i);
                    }
                    return o && (E = h, x = d), c;
                }, y ? re(i) : i))).selector = e;
            }
            return s;
        }, v = ie.select = function(e, t, n, i) {
            var o, r, s, a, l, u = "function" == typeof e && e, c = !i && m(e = u.selector || e);
            if (n = n || [], 1 === c.length) {
                if (2 < (r = c[0] = c[0].slice(0)).length && "ID" === (s = r[0]).type && h.getById && 9 === t.nodeType && S && w.relative[r[1].type]) {
                    if (!(t = (w.find.ID(s.matches[0].replace(ee, te), t) || [])[0])) return n;
                    u && (t = t.parentNode), e = e.slice(r.shift().value.length);
                }
                for (o = U.needsContext.test(e) ? 0 : r.length; o-- && (s = r[o], !w.relative[a = s.type]); ) if ((l = w.find[a]) && (i = l(s.matches[0].replace(ee, te), K.test(r[0].type) && de(t.parentNode) || t))) {
                    if (r.splice(o, 1), !(e = i.length && he(r))) return P.apply(n, i), n;
                    break;
                }
            }
            return (u || p(e, c))(i, t, !S, n, !t || K.test(e) && de(t.parentNode) || t), n;
        }, h.sortStable = k.split("").sort(N).join("") === k, h.detectDuplicates = !!u, 
        C(), h.sortDetached = se(function(e) {
            return 1 & e.compareDocumentPosition(T.createElement("div"));
        }), se(function(e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href");
        }) || ae("type|href|height|width", function(e, t, n) {
            return n ? void 0 : e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2);
        }), h.attributes && se(function(e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value");
        }) || ae("value", function(e, t, n) {
            return n || "input" !== e.nodeName.toLowerCase() ? void 0 : e.defaultValue;
        }), se(function(e) {
            return null == e.getAttribute("disabled");
        }) || ae(H, function(e, t, n) {
            var i;
            return n ? void 0 : !0 === e[t] ? t.toLowerCase() : (i = e.getAttributeNode(t)) && i.specified ? i.value : null;
        }), ie;
    }(T);
    S.find = f, S.expr = f.selectors, S.expr[":"] = S.expr.pseudos, S.uniqueSort = S.unique = f.uniqueSort, 
    S.text = f.getText, S.isXMLDoc = f.isXML, S.contains = f.contains;
    var y = function(e, t, n) {
        for (var i = [], o = void 0 !== n; (e = e[t]) && 9 !== e.nodeType; ) if (1 === e.nodeType) {
            if (o && S(e).is(n)) break;
            i.push(e);
        }
        return i;
    }, b = function(e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n;
    }, w = S.expr.match.needsContext, x = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/, C = /^.[^:#\[\.,]*$/;
    function k(e, n, i) {
        if (S.isFunction(n)) return S.grep(e, function(e, t) {
            return !!n.call(e, t, e) !== i;
        });
        if (n.nodeType) return S.grep(e, function(e) {
            return e === n !== i;
        });
        if ("string" == typeof n) {
            if (C.test(n)) return S.filter(n, e, i);
            n = S.filter(n, e);
        }
        return S.grep(e, function(e) {
            return -1 < S.inArray(e, n) !== i;
        });
    }
    S.filter = function(e, t, n) {
        var i = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? S.find.matchesSelector(i, e) ? [ i ] : [] : S.find.matches(e, S.grep(t, function(e) {
            return 1 === e.nodeType;
        }));
    }, S.fn.extend({
        find: function(e) {
            var t, n = [], i = this, o = i.length;
            if ("string" != typeof e) return this.pushStack(S(e).filter(function() {
                for (t = 0; t < o; t++) if (S.contains(i[t], this)) return !0;
            }));
            for (t = 0; t < o; t++) S.find(e, i[t], n);
            return (n = this.pushStack(1 < o ? S.unique(n) : n)).selector = this.selector ? this.selector + " " + e : e, 
            n;
        },
        filter: function(e) {
            return this.pushStack(k(this, e || [], !1));
        },
        not: function(e) {
            return this.pushStack(k(this, e || [], !0));
        },
        is: function(e) {
            return !!k(this, "string" == typeof e && w.test(e) ? S(e) : e || [], !1).length;
        }
    });
    var E, I = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/;
    (S.fn.init = function(e, t, n) {
        var i, o;
        if (!e) return this;
        if (n = n || E, "string" == typeof e) {
            if (!(i = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && 3 <= e.length ? [ null, e, null ] : I.exec(e)) || !i[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
            if (i[1]) {
                if (t = t instanceof S ? t[0] : t, S.merge(this, S.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : h, !0)), 
                x.test(i[1]) && S.isPlainObject(t)) for (i in t) S.isFunction(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
                return this;
            }
            if ((o = h.getElementById(i[2])) && o.parentNode) {
                if (o.id !== i[2]) return E.find(e);
                this.length = 1, this[0] = o;
            }
            return this.context = h, this.selector = e, this;
        }
        return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : S.isFunction(e) ? void 0 !== n.ready ? n.ready(e) : e(S) : (void 0 !== e.selector && (this.selector = e.selector, 
        this.context = e.context), S.makeArray(e, this));
    }).prototype = S.fn, E = S(h);
    var N = /^(?:parents|prev(?:Until|All))/, A = {
        children: !0,
        contents: !0,
        next: !0,
        prev: !0
    };
    function D(e, t) {
        for (;(e = e[t]) && 1 !== e.nodeType; ) ;
        return e;
    }
    S.fn.extend({
        has: function(e) {
            var t, n = S(e, this), i = n.length;
            return this.filter(function() {
                for (t = 0; t < i; t++) if (S.contains(this, n[t])) return !0;
            });
        },
        closest: function(e, t) {
            for (var n, i = 0, o = this.length, r = [], s = w.test(e) || "string" != typeof e ? S(e, t || this.context) : 0; i < o; i++) for (n = this[i]; n && n !== t; n = n.parentNode) if (n.nodeType < 11 && (s ? -1 < s.index(n) : 1 === n.nodeType && S.find.matchesSelector(n, e))) {
                r.push(n);
                break;
            }
            return this.pushStack(1 < r.length ? S.uniqueSort(r) : r);
        },
        index: function(e) {
            return e ? "string" == typeof e ? S.inArray(this[0], S(e)) : S.inArray(e.jquery ? e[0] : e, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
        },
        add: function(e, t) {
            return this.pushStack(S.uniqueSort(S.merge(this.get(), S(e, t))));
        },
        addBack: function(e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e));
        }
    }), S.each({
        parent: function(e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null;
        },
        parents: function(e) {
            return y(e, "parentNode");
        },
        parentsUntil: function(e, t, n) {
            return y(e, "parentNode", n);
        },
        next: function(e) {
            return D(e, "nextSibling");
        },
        prev: function(e) {
            return D(e, "previousSibling");
        },
        nextAll: function(e) {
            return y(e, "nextSibling");
        },
        prevAll: function(e) {
            return y(e, "previousSibling");
        },
        nextUntil: function(e, t, n) {
            return y(e, "nextSibling", n);
        },
        prevUntil: function(e, t, n) {
            return y(e, "previousSibling", n);
        },
        siblings: function(e) {
            return b((e.parentNode || {}).firstChild, e);
        },
        children: function(e) {
            return b(e.firstChild);
        },
        contents: function(e) {
            return S.nodeName(e, "iframe") ? e.contentDocument || e.contentWindow.document : S.merge([], e.childNodes);
        }
    }, function(i, o) {
        S.fn[i] = function(e, t) {
            var n = S.map(this, o, e);
            return "Until" !== i.slice(-5) && (t = e), t && "string" == typeof t && (n = S.filter(t, n)), 
            1 < this.length && (A[i] || (n = S.uniqueSort(n)), N.test(i) && (n = n.reverse())), 
            this.pushStack(n);
        };
    });
    var j, P, L = /\S+/g;
    function $() {
        h.addEventListener ? (h.removeEventListener("DOMContentLoaded", H), T.removeEventListener("load", H)) : (h.detachEvent("onreadystatechange", H), 
        T.detachEvent("onload", H));
    }
    function H() {
        (h.addEventListener || "load" === T.event.type || "complete" === h.readyState) && ($(), 
        S.ready());
    }
    for (P in S.Callbacks = function(i) {
        var e, n;
        i = "string" == typeof i ? (e = i, n = {}, S.each(e.match(L) || [], function(e, t) {
            n[t] = !0;
        }), n) : S.extend({}, i);
        var o, t, r, s, a = [], l = [], u = -1, c = function() {
            for (s = i.once, r = o = !0; l.length; u = -1) for (t = l.shift(); ++u < a.length; ) !1 === a[u].apply(t[0], t[1]) && i.stopOnFalse && (u = a.length, 
            t = !1);
            i.memory || (t = !1), o = !1, s && (a = t ? [] : "");
        }, p = {
            add: function() {
                return a && (t && !o && (u = a.length - 1, l.push(t)), function n(e) {
                    S.each(e, function(e, t) {
                        S.isFunction(t) ? i.unique && p.has(t) || a.push(t) : t && t.length && "string" !== S.type(t) && n(t);
                    });
                }(arguments), t && !o && c()), this;
            },
            remove: function() {
                return S.each(arguments, function(e, t) {
                    for (var n; -1 < (n = S.inArray(t, a, n)); ) a.splice(n, 1), n <= u && u--;
                }), this;
            },
            has: function(e) {
                return e ? -1 < S.inArray(e, a) : 0 < a.length;
            },
            empty: function() {
                return a && (a = []), this;
            },
            disable: function() {
                return s = l = [], a = t = "", this;
            },
            disabled: function() {
                return !a;
            },
            lock: function() {
                return s = !0, t || p.disable(), this;
            },
            locked: function() {
                return !!s;
            },
            fireWith: function(e, t) {
                return s || (t = [ e, (t = t || []).slice ? t.slice() : t ], l.push(t), o || c()), 
                this;
            },
            fire: function() {
                return p.fireWith(this, arguments), this;
            },
            fired: function() {
                return !!r;
            }
        };
        return p;
    }, S.extend({
        Deferred: function(e) {
            var r = [ [ "resolve", "done", S.Callbacks("once memory"), "resolved" ], [ "reject", "fail", S.Callbacks("once memory"), "rejected" ], [ "notify", "progress", S.Callbacks("memory") ] ], o = "pending", s = {
                state: function() {
                    return o;
                },
                always: function() {
                    return a.done(arguments).fail(arguments), this;
                },
                then: function() {
                    var o = arguments;
                    return S.Deferred(function(i) {
                        S.each(r, function(e, t) {
                            var n = S.isFunction(o[e]) && o[e];
                            a[t[1]](function() {
                                var e = n && n.apply(this, arguments);
                                e && S.isFunction(e.promise) ? e.promise().progress(i.notify).done(i.resolve).fail(i.reject) : i[t[0] + "With"](this === s ? i.promise() : this, n ? [ e ] : arguments);
                            });
                        }), o = null;
                    }).promise();
                },
                promise: function(e) {
                    return null != e ? S.extend(e, s) : s;
                }
            }, a = {};
            return s.pipe = s.then, S.each(r, function(e, t) {
                var n = t[2], i = t[3];
                s[t[1]] = n.add, i && n.add(function() {
                    o = i;
                }, r[1 ^ e][2].disable, r[2][2].lock), a[t[0]] = function() {
                    return a[t[0] + "With"](this === a ? s : this, arguments), this;
                }, a[t[0] + "With"] = n.fireWith;
            }), s.promise(a), e && e.call(a, a), a;
        },
        when: function(e) {
            var o, t, n, i = 0, r = c.call(arguments), s = r.length, a = 1 !== s || e && S.isFunction(e.promise) ? s : 0, l = 1 === a ? e : S.Deferred(), u = function(t, n, i) {
                return function(e) {
                    n[t] = this, i[t] = 1 < arguments.length ? c.call(arguments) : e, i === o ? l.notifyWith(n, i) : --a || l.resolveWith(n, i);
                };
            };
            if (1 < s) for (o = new Array(s), t = new Array(s), n = new Array(s); i < s; i++) r[i] && S.isFunction(r[i].promise) ? r[i].promise().progress(u(i, t, o)).done(u(i, n, r)).fail(l.reject) : --a;
            return a || l.resolveWith(n, r), l.promise();
        }
    }), S.fn.ready = function(e) {
        return S.ready.promise().done(e), this;
    }, S.extend({
        isReady: !1,
        readyWait: 1,
        holdReady: function(e) {
            e ? S.readyWait++ : S.ready(!0);
        },
        ready: function(e) {
            (!0 === e ? --S.readyWait : S.isReady) || ((S.isReady = !0) !== e && 0 < --S.readyWait || (j.resolveWith(h, [ S ]), 
            S.fn.triggerHandler && (S(h).triggerHandler("ready"), S(h).off("ready"))));
        }
    }), S.ready.promise = function(e) {
        if (!j) if (j = S.Deferred(), "complete" === h.readyState || "loading" !== h.readyState && !h.documentElement.doScroll) T.setTimeout(S.ready); else if (h.addEventListener) h.addEventListener("DOMContentLoaded", H), 
        T.addEventListener("load", H); else {
            h.attachEvent("onreadystatechange", H), T.attachEvent("onload", H);
            var n = !1;
            try {
                n = null == T.frameElement && h.documentElement;
            } catch (e) {}
            n && n.doScroll && function t() {
                if (!S.isReady) {
                    try {
                        n.doScroll("left");
                    } catch (e) {
                        return T.setTimeout(t, 50);
                    }
                    $(), S.ready();
                }
            }();
        }
        return j.promise(e);
    }, S.ready.promise(), S(g)) break;
    g.ownFirst = "0" === P, g.inlineBlockNeedsLayout = !1, S(function() {
        var e, t, n, i;
        (n = h.getElementsByTagName("body")[0]) && n.style && (t = h.createElement("div"), 
        (i = h.createElement("div")).style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", 
        n.appendChild(i).appendChild(t), void 0 !== t.style.zoom && (t.style.cssText = "display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1", 
        g.inlineBlockNeedsLayout = e = 3 === t.offsetWidth, e && (n.style.zoom = 1)), n.removeChild(i));
    }), function() {
        var e = h.createElement("div");
        g.deleteExpando = !0;
        try {
            delete e.test;
        } catch (e) {
            g.deleteExpando = !1;
        }
        e = null;
    }();
    var q, W = function(e) {
        var t = S.noData[(e.nodeName + " ").toLowerCase()], n = +e.nodeType || 1;
        return (1 === n || 9 === n) && (!t || !0 !== t && e.getAttribute("classid") === t);
    }, M = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, O = /([A-Z])/g;
    function _(e, t, n) {
        if (void 0 === n && 1 === e.nodeType) {
            var i = "data-" + t.replace(O, "-$1").toLowerCase();
            if ("string" == typeof (n = e.getAttribute(i))) {
                try {
                    n = "true" === n || "false" !== n && ("null" === n ? null : +n + "" === n ? +n : M.test(n) ? S.parseJSON(n) : n);
                } catch (e) {}
                S.data(e, t, n);
            } else n = void 0;
        }
        return n;
    }
    function F(e) {
        var t;
        for (t in e) if (("data" !== t || !S.isEmptyObject(e[t])) && "toJSON" !== t) return !1;
        return !0;
    }
    function R(e, t, n, i) {
        if (W(e)) {
            var o, r, s = S.expando, a = e.nodeType, l = a ? S.cache : e, u = a ? e[s] : e[s] && s;
            if (u && l[u] && (i || l[u].data) || void 0 !== n || "string" != typeof t) return u || (u = a ? e[s] = p.pop() || S.guid++ : s), 
            l[u] || (l[u] = a ? {} : {
                toJSON: S.noop
            }), "object" != typeof t && "function" != typeof t || (i ? l[u] = S.extend(l[u], t) : l[u].data = S.extend(l[u].data, t)), 
            r = l[u], i || (r.data || (r.data = {}), r = r.data), void 0 !== n && (r[S.camelCase(t)] = n), 
            "string" == typeof t ? null == (o = r[t]) && (o = r[S.camelCase(t)]) : o = r, o;
        }
    }
    function z(e, t, n) {
        if (W(e)) {
            var i, o, r = e.nodeType, s = r ? S.cache : e, a = r ? e[S.expando] : S.expando;
            if (s[a]) {
                if (t && (i = n ? s[a] : s[a].data)) {
                    S.isArray(t) ? t = t.concat(S.map(t, S.camelCase)) : t in i ? t = [ t ] : t = (t = S.camelCase(t)) in i ? [ t ] : t.split(" "), 
                    o = t.length;
                    for (;o--; ) delete i[t[o]];
                    if (n ? !F(i) : !S.isEmptyObject(i)) return;
                }
                (n || (delete s[a].data, F(s[a]))) && (r ? S.cleanData([ e ], !0) : g.deleteExpando || s != s.window ? delete s[a] : s[a] = void 0);
            }
        }
    }
    S.extend({
        cache: {},
        noData: {
            "applet ": !0,
            "embed ": !0,
            "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
        },
        hasData: function(e) {
            return !!(e = e.nodeType ? S.cache[e[S.expando]] : e[S.expando]) && !F(e);
        },
        data: function(e, t, n) {
            return R(e, t, n);
        },
        removeData: function(e, t) {
            return z(e, t);
        },
        _data: function(e, t, n) {
            return R(e, t, n, !0);
        },
        _removeData: function(e, t) {
            return z(e, t, !0);
        }
    }), S.fn.extend({
        data: function(e, t) {
            var n, i, o, r = this[0], s = r && r.attributes;
            if (void 0 === e) {
                if (this.length && (o = S.data(r), 1 === r.nodeType && !S._data(r, "parsedAttrs"))) {
                    for (n = s.length; n--; ) s[n] && (0 === (i = s[n].name).indexOf("data-") && _(r, i = S.camelCase(i.slice(5)), o[i]));
                    S._data(r, "parsedAttrs", !0);
                }
                return o;
            }
            return "object" == typeof e ? this.each(function() {
                S.data(this, e);
            }) : 1 < arguments.length ? this.each(function() {
                S.data(this, e, t);
            }) : r ? _(r, e, S.data(r, e)) : void 0;
        },
        removeData: function(e) {
            return this.each(function() {
                S.removeData(this, e);
            });
        }
    }), S.extend({
        queue: function(e, t, n) {
            var i;
            return e ? (t = (t || "fx") + "queue", i = S._data(e, t), n && (!i || S.isArray(n) ? i = S._data(e, t, S.makeArray(n)) : i.push(n)), 
            i || []) : void 0;
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = S.queue(e, t), i = n.length, o = n.shift(), r = S._queueHooks(e, t);
            "inprogress" === o && (o = n.shift(), i--), o && ("fx" === t && n.unshift("inprogress"), 
            delete r.stop, o.call(e, function() {
                S.dequeue(e, t);
            }, r)), !i && r && r.empty.fire();
        },
        _queueHooks: function(e, t) {
            var n = t + "queueHooks";
            return S._data(e, n) || S._data(e, n, {
                empty: S.Callbacks("once memory").add(function() {
                    S._removeData(e, t + "queue"), S._removeData(e, n);
                })
            });
        }
    }), S.fn.extend({
        queue: function(t, n) {
            var e = 2;
            return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? S.queue(this[0], t) : void 0 === n ? this : this.each(function() {
                var e = S.queue(this, t, n);
                S._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && S.dequeue(this, t);
            });
        },
        dequeue: function(e) {
            return this.each(function() {
                S.dequeue(this, e);
            });
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", []);
        },
        promise: function(e, t) {
            var n, i = 1, o = S.Deferred(), r = this, s = this.length, a = function() {
                --i || o.resolveWith(r, [ r ]);
            };
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; s--; ) (n = S._data(r[s], e + "queueHooks")) && n.empty && (i++, 
            n.empty.add(a));
            return a(), o.promise(t);
        }
    }), g.shrinkWrapBlocks = function() {
        return null != q ? q : (q = !1, (t = h.getElementsByTagName("body")[0]) && t.style ? (e = h.createElement("div"), 
        (n = h.createElement("div")).style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", 
        t.appendChild(n).appendChild(e), void 0 !== e.style.zoom && (e.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", 
        e.appendChild(h.createElement("div")).style.width = "5px", q = 3 !== e.offsetWidth), 
        t.removeChild(n), q) : void 0);
        var e, t, n;
    };
    var B = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, X = new RegExp("^(?:([+-])=|)(" + B + ")([a-z%]*)$", "i"), V = [ "Top", "Right", "Bottom", "Left" ], U = function(e, t) {
        return e = t || e, "none" === S.css(e, "display") || !S.contains(e.ownerDocument, e);
    };
    function Y(e, t, n, i) {
        var o, r = 1, s = 20, a = i ? function() {
            return i.cur();
        } : function() {
            return S.css(e, t, "");
        }, l = a(), u = n && n[3] || (S.cssNumber[t] ? "" : "px"), c = (S.cssNumber[t] || "px" !== u && +l) && X.exec(S.css(e, t));
        if (c && c[3] !== u) for (u = u || c[3], n = n || [], c = +l || 1; c /= r = r || ".5", 
        S.style(e, t, c + u), r !== (r = a() / l) && 1 !== r && --s; ) ;
        return n && (c = +c || +l || 0, o = n[1] ? c + (n[1] + 1) * n[2] : +n[2], i && (i.unit = u, 
        i.start = c, i.end = o)), o;
    }
    var G, J, Q, K = function(e, t, n, i, o, r, s) {
        var a = 0, l = e.length, u = null == n;
        if ("object" === S.type(n)) for (a in o = !0, n) K(e, t, a, n[a], !0, r, s); else if (void 0 !== i && (o = !0, 
        S.isFunction(i) || (s = !0), u && (s ? (t.call(e, i), t = null) : (u = t, t = function(e, t, n) {
            return u.call(S(e), n);
        })), t)) for (;a < l; a++) t(e[a], n, s ? i : i.call(e[a], a, t(e[a], n)));
        return o ? e : u ? t.call(e) : l ? t(e[0], n) : r;
    }, Z = /^(?:checkbox|radio)$/i, ee = /<([\w:-]+)/, te = /^$|\/(?:java|ecma)script/i, ne = /^\s+/, ie = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|dialog|figcaption|figure|footer|header|hgroup|main|mark|meter|nav|output|picture|progress|section|summary|template|time|video";
    function oe(e) {
        var t = ie.split("|"), n = e.createDocumentFragment();
        if (n.createElement) for (;t.length; ) n.createElement(t.pop());
        return n;
    }
    G = h.createElement("div"), J = h.createDocumentFragment(), Q = h.createElement("input"), 
    G.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", 
    g.leadingWhitespace = 3 === G.firstChild.nodeType, g.tbody = !G.getElementsByTagName("tbody").length, 
    g.htmlSerialize = !!G.getElementsByTagName("link").length, g.html5Clone = "<:nav></:nav>" !== h.createElement("nav").cloneNode(!0).outerHTML, 
    Q.type = "checkbox", Q.checked = !0, J.appendChild(Q), g.appendChecked = Q.checked, 
    G.innerHTML = "<textarea>x</textarea>", g.noCloneChecked = !!G.cloneNode(!0).lastChild.defaultValue, 
    J.appendChild(G), (Q = h.createElement("input")).setAttribute("type", "radio"), 
    Q.setAttribute("checked", "checked"), Q.setAttribute("name", "t"), G.appendChild(Q), 
    g.checkClone = G.cloneNode(!0).cloneNode(!0).lastChild.checked, g.noCloneEvent = !!G.addEventListener, 
    G[S.expando] = 1, g.attributes = !G.getAttribute(S.expando);
    var re = {
        option: [ 1, "<select multiple='multiple'>", "</select>" ],
        legend: [ 1, "<fieldset>", "</fieldset>" ],
        area: [ 1, "<map>", "</map>" ],
        param: [ 1, "<object>", "</object>" ],
        thead: [ 1, "<table>", "</table>" ],
        tr: [ 2, "<table><tbody>", "</tbody></table>" ],
        col: [ 2, "<table><tbody></tbody><colgroup>", "</colgroup></table>" ],
        td: [ 3, "<table><tbody><tr>", "</tr></tbody></table>" ],
        _default: g.htmlSerialize ? [ 0, "", "" ] : [ 1, "X<div>", "</div>" ]
    };
    function se(e, t) {
        var n, i, o = 0, r = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : void 0;
        if (!r) for (r = [], n = e.childNodes || e; null != (i = n[o]); o++) !t || S.nodeName(i, t) ? r.push(i) : S.merge(r, se(i, t));
        return void 0 === t || t && S.nodeName(e, t) ? S.merge([ e ], r) : r;
    }
    function ae(e, t) {
        for (var n, i = 0; null != (n = e[i]); i++) S._data(n, "globalEval", !t || S._data(t[i], "globalEval"));
    }
    re.optgroup = re.option, re.tbody = re.tfoot = re.colgroup = re.caption = re.thead, 
    re.th = re.td;
    var le = /<|&#?\w+;/, ue = /<tbody/i;
    function ce(e) {
        Z.test(e.type) && (e.defaultChecked = e.checked);
    }
    function pe(e, t, n, i, o) {
        for (var r, s, a, l, u, c, p, d = e.length, f = oe(t), h = [], m = 0; m < d; m++) if ((s = e[m]) || 0 === s) if ("object" === S.type(s)) S.merge(h, s.nodeType ? [ s ] : s); else if (le.test(s)) {
            for (l = l || f.appendChild(t.createElement("div")), u = (ee.exec(s) || [ "", "" ])[1].toLowerCase(), 
            p = re[u] || re._default, l.innerHTML = p[1] + S.htmlPrefilter(s) + p[2], r = p[0]; r--; ) l = l.lastChild;
            if (!g.leadingWhitespace && ne.test(s) && h.push(t.createTextNode(ne.exec(s)[0])), 
            !g.tbody) for (r = (s = "table" !== u || ue.test(s) ? "<table>" !== p[1] || ue.test(s) ? 0 : l : l.firstChild) && s.childNodes.length; r--; ) S.nodeName(c = s.childNodes[r], "tbody") && !c.childNodes.length && s.removeChild(c);
            for (S.merge(h, l.childNodes), l.textContent = ""; l.firstChild; ) l.removeChild(l.firstChild);
            l = f.lastChild;
        } else h.push(t.createTextNode(s));
        for (l && f.removeChild(l), g.appendChecked || S.grep(se(h, "input"), ce), m = 0; s = h[m++]; ) if (i && -1 < S.inArray(s, i)) o && o.push(s); else if (a = S.contains(s.ownerDocument, s), 
        l = se(f.appendChild(s), "script"), a && ae(l), n) for (r = 0; s = l[r++]; ) te.test(s.type || "") && n.push(s);
        return l = null, f;
    }
    !function() {
        var e, t, n = h.createElement("div");
        for (e in {
            submit: !0,
            change: !0,
            focusin: !0
        }) t = "on" + e, (g[e] = t in T) || (n.setAttribute(t, "t"), g[e] = !1 === n.attributes[t].expando);
        n = null;
    }();
    var de = /^(?:input|select|textarea)$/i, fe = /^key/, he = /^(?:mouse|pointer|contextmenu|drag|drop)|click/, me = /^(?:focusinfocus|focusoutblur)$/, ve = /^([^.]*)(?:\.(.+)|)/;
    function ge() {
        return !0;
    }
    function ye() {
        return !1;
    }
    function be() {
        try {
            return h.activeElement;
        } catch (e) {}
    }
    function we(e, t, n, i, o, r) {
        var s, a;
        if ("object" == typeof t) {
            for (a in "string" != typeof n && (i = i || n, n = void 0), t) we(e, a, n, i, t[a], r);
            return e;
        }
        if (null == i && null == o ? (o = n, i = n = void 0) : null == o && ("string" == typeof n ? (o = i, 
        i = void 0) : (o = i, i = n, n = void 0)), !1 === o) o = ye; else if (!o) return e;
        return 1 === r && (s = o, (o = function(e) {
            return S().off(e), s.apply(this, arguments);
        }).guid = s.guid || (s.guid = S.guid++)), e.each(function() {
            S.event.add(this, t, o, i, n);
        });
    }
    S.event = {
        global: {},
        add: function(e, t, n, i, o) {
            var r, s, a, l, u, c, p, d, f, h, m, v = S._data(e);
            if (v) {
                for (n.handler && (n = (l = n).handler, o = l.selector), n.guid || (n.guid = S.guid++), 
                (s = v.events) || (s = v.events = {}), (c = v.handle) || ((c = v.handle = function(e) {
                    return void 0 === S || e && S.event.triggered === e.type ? void 0 : S.event.dispatch.apply(c.elem, arguments);
                }).elem = e), a = (t = (t || "").match(L) || [ "" ]).length; a--; ) f = m = (r = ve.exec(t[a]) || [])[1], 
                h = (r[2] || "").split(".").sort(), f && (u = S.event.special[f] || {}, f = (o ? u.delegateType : u.bindType) || f, 
                u = S.event.special[f] || {}, p = S.extend({
                    type: f,
                    origType: m,
                    data: i,
                    handler: n,
                    guid: n.guid,
                    selector: o,
                    needsContext: o && S.expr.match.needsContext.test(o),
                    namespace: h.join(".")
                }, l), (d = s[f]) || ((d = s[f] = []).delegateCount = 0, u.setup && !1 !== u.setup.call(e, i, h, c) || (e.addEventListener ? e.addEventListener(f, c, !1) : e.attachEvent && e.attachEvent("on" + f, c))), 
                u.add && (u.add.call(e, p), p.handler.guid || (p.handler.guid = n.guid)), o ? d.splice(d.delegateCount++, 0, p) : d.push(p), 
                S.event.global[f] = !0);
                e = null;
            }
        },
        remove: function(e, t, n, i, o) {
            var r, s, a, l, u, c, p, d, f, h, m, v = S.hasData(e) && S._data(e);
            if (v && (c = v.events)) {
                for (u = (t = (t || "").match(L) || [ "" ]).length; u--; ) if (f = m = (a = ve.exec(t[u]) || [])[1], 
                h = (a[2] || "").split(".").sort(), f) {
                    for (p = S.event.special[f] || {}, d = c[f = (i ? p.delegateType : p.bindType) || f] || [], 
                    a = a[2] && new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), l = r = d.length; r--; ) s = d[r], 
                    !o && m !== s.origType || n && n.guid !== s.guid || a && !a.test(s.namespace) || i && i !== s.selector && ("**" !== i || !s.selector) || (d.splice(r, 1), 
                    s.selector && d.delegateCount--, p.remove && p.remove.call(e, s));
                    l && !d.length && (p.teardown && !1 !== p.teardown.call(e, h, v.handle) || S.removeEvent(e, f, v.handle), 
                    delete c[f]);
                } else for (f in c) S.event.remove(e, f + t[u], n, i, !0);
                S.isEmptyObject(c) && (delete v.handle, S._removeData(e, "events"));
            }
        },
        trigger: function(e, t, n, i) {
            var o, r, s, a, l, u, c, p = [ n || h ], d = v.call(e, "type") ? e.type : e, f = v.call(e, "namespace") ? e.namespace.split(".") : [];
            if (s = u = n = n || h, 3 !== n.nodeType && 8 !== n.nodeType && !me.test(d + S.event.triggered) && (-1 < d.indexOf(".") && (d = (f = d.split(".")).shift(), 
            f.sort()), r = d.indexOf(":") < 0 && "on" + d, (e = e[S.expando] ? e : new S.Event(d, "object" == typeof e && e)).isTrigger = i ? 2 : 3, 
            e.namespace = f.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, 
            e.result = void 0, e.target || (e.target = n), t = null == t ? [ e ] : S.makeArray(t, [ e ]), 
            l = S.event.special[d] || {}, i || !l.trigger || !1 !== l.trigger.apply(n, t))) {
                if (!i && !l.noBubble && !S.isWindow(n)) {
                    for (a = l.delegateType || d, me.test(a + d) || (s = s.parentNode); s; s = s.parentNode) p.push(s), 
                    u = s;
                    u === (n.ownerDocument || h) && p.push(u.defaultView || u.parentWindow || T);
                }
                for (c = 0; (s = p[c++]) && !e.isPropagationStopped(); ) e.type = 1 < c ? a : l.bindType || d, 
                (o = (S._data(s, "events") || {})[e.type] && S._data(s, "handle")) && o.apply(s, t), 
                (o = r && s[r]) && o.apply && W(s) && (e.result = o.apply(s, t), !1 === e.result && e.preventDefault());
                if (e.type = d, !i && !e.isDefaultPrevented() && (!l._default || !1 === l._default.apply(p.pop(), t)) && W(n) && r && n[d] && !S.isWindow(n)) {
                    (u = n[r]) && (n[r] = null), S.event.triggered = d;
                    try {
                        n[d]();
                    } catch (e) {}
                    S.event.triggered = void 0, u && (n[r] = u);
                }
                return e.result;
            }
        },
        dispatch: function(e) {
            e = S.event.fix(e);
            var t, n, i, o, r, s = [], a = c.call(arguments), l = (S._data(this, "events") || {})[e.type] || [], u = S.event.special[e.type] || {};
            if ((a[0] = e).delegateTarget = this, !u.preDispatch || !1 !== u.preDispatch.call(this, e)) {
                for (s = S.event.handlers.call(this, e, l), t = 0; (o = s[t++]) && !e.isPropagationStopped(); ) for (e.currentTarget = o.elem, 
                n = 0; (r = o.handlers[n++]) && !e.isImmediatePropagationStopped(); ) e.rnamespace && !e.rnamespace.test(r.namespace) || (e.handleObj = r, 
                e.data = r.data, void 0 !== (i = ((S.event.special[r.origType] || {}).handle || r.handler).apply(o.elem, a)) && !1 === (e.result = i) && (e.preventDefault(), 
                e.stopPropagation()));
                return u.postDispatch && u.postDispatch.call(this, e), e.result;
            }
        },
        handlers: function(e, t) {
            var n, i, o, r, s = [], a = t.delegateCount, l = e.target;
            if (a && l.nodeType && ("click" !== e.type || isNaN(e.button) || e.button < 1)) for (;l != this; l = l.parentNode || this) if (1 === l.nodeType && (!0 !== l.disabled || "click" !== e.type)) {
                for (i = [], n = 0; n < a; n++) void 0 === i[o = (r = t[n]).selector + " "] && (i[o] = r.needsContext ? -1 < S(o, this).index(l) : S.find(o, this, null, [ l ]).length), 
                i[o] && i.push(r);
                i.length && s.push({
                    elem: l,
                    handlers: i
                });
            }
            return a < t.length && s.push({
                elem: this,
                handlers: t.slice(a)
            }), s;
        },
        fix: function(e) {
            if (e[S.expando]) return e;
            var t, n, i, o = e.type, r = e, s = this.fixHooks[o];
            for (s || (this.fixHooks[o] = s = he.test(o) ? this.mouseHooks : fe.test(o) ? this.keyHooks : {}), 
            i = s.props ? this.props.concat(s.props) : this.props, e = new S.Event(r), t = i.length; t--; ) e[n = i[t]] = r[n];
            return e.target || (e.target = r.srcElement || h), 3 === e.target.nodeType && (e.target = e.target.parentNode), 
            e.metaKey = !!e.metaKey, s.filter ? s.filter(e, r) : e;
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "),
            filter: function(e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), 
                e;
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function(e, t) {
                var n, i, o, r = t.button, s = t.fromElement;
                return null == e.pageX && null != t.clientX && (o = (i = e.target.ownerDocument || h).documentElement, 
                n = i.body, e.pageX = t.clientX + (o && o.scrollLeft || n && n.scrollLeft || 0) - (o && o.clientLeft || n && n.clientLeft || 0), 
                e.pageY = t.clientY + (o && o.scrollTop || n && n.scrollTop || 0) - (o && o.clientTop || n && n.clientTop || 0)), 
                !e.relatedTarget && s && (e.relatedTarget = s === e.target ? t.toElement : s), e.which || void 0 === r || (e.which = 1 & r ? 1 : 2 & r ? 3 : 4 & r ? 2 : 0), 
                e;
            }
        },
        special: {
            load: {
                noBubble: !0
            },
            focus: {
                trigger: function() {
                    if (this !== be() && this.focus) try {
                        return this.focus(), !1;
                    } catch (e) {}
                },
                delegateType: "focusin"
            },
            blur: {
                trigger: function() {
                    return this === be() && this.blur ? (this.blur(), !1) : void 0;
                },
                delegateType: "focusout"
            },
            click: {
                trigger: function() {
                    return S.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), 
                    !1) : void 0;
                },
                _default: function(e) {
                    return S.nodeName(e.target, "a");
                }
            },
            beforeunload: {
                postDispatch: function(e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result);
                }
            }
        },
        simulate: function(e, t, n) {
            var i = S.extend(new S.Event(), n, {
                type: e,
                isSimulated: !0
            });
            S.event.trigger(i, null, t), i.isDefaultPrevented() && n.preventDefault();
        }
    }, S.removeEvent = h.removeEventListener ? function(e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n);
    } : function(e, t, n) {
        var i = "on" + t;
        e.detachEvent && (void 0 === e[i] && (e[i] = null), e.detachEvent(i, n));
    }, S.Event = function(e, t) {
        return this instanceof S.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, 
        this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? ge : ye) : this.type = e, 
        t && S.extend(this, t), this.timeStamp = e && e.timeStamp || S.now(), void (this[S.expando] = !0)) : new S.Event(e, t);
    }, S.Event.prototype = {
        constructor: S.Event,
        isDefaultPrevented: ye,
        isPropagationStopped: ye,
        isImmediatePropagationStopped: ye,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = ge, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1);
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = ge, e && !this.isSimulated && (e.stopPropagation && e.stopPropagation(), 
            e.cancelBubble = !0);
        },
        stopImmediatePropagation: function() {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = ge, e && e.stopImmediatePropagation && e.stopImmediatePropagation(), 
            this.stopPropagation();
        }
    }, S.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function(e, o) {
        S.event.special[e] = {
            delegateType: o,
            bindType: o,
            handle: function(e) {
                var t, n = e.relatedTarget, i = e.handleObj;
                return n && (n === this || S.contains(this, n)) || (e.type = i.origType, t = i.handler.apply(this, arguments), 
                e.type = o), t;
            }
        };
    }), g.submit || (S.event.special.submit = {
        setup: function() {
            return !S.nodeName(this, "form") && void S.event.add(this, "click._submit keypress._submit", function(e) {
                var t = e.target, n = S.nodeName(t, "input") || S.nodeName(t, "button") ? S.prop(t, "form") : void 0;
                n && !S._data(n, "submit") && (S.event.add(n, "submit._submit", function(e) {
                    e._submitBubble = !0;
                }), S._data(n, "submit", !0));
            });
        },
        postDispatch: function(e) {
            e._submitBubble && (delete e._submitBubble, this.parentNode && !e.isTrigger && S.event.simulate("submit", this.parentNode, e));
        },
        teardown: function() {
            return !S.nodeName(this, "form") && void S.event.remove(this, "._submit");
        }
    }), g.change || (S.event.special.change = {
        setup: function() {
            return de.test(this.nodeName) ? ("checkbox" !== this.type && "radio" !== this.type || (S.event.add(this, "propertychange._change", function(e) {
                "checked" === e.originalEvent.propertyName && (this._justChanged = !0);
            }), S.event.add(this, "click._change", function(e) {
                this._justChanged && !e.isTrigger && (this._justChanged = !1), S.event.simulate("change", this, e);
            })), !1) : void S.event.add(this, "beforeactivate._change", function(e) {
                var t = e.target;
                de.test(t.nodeName) && !S._data(t, "change") && (S.event.add(t, "change._change", function(e) {
                    !this.parentNode || e.isSimulated || e.isTrigger || S.event.simulate("change", this.parentNode, e);
                }), S._data(t, "change", !0));
            });
        },
        handle: function(e) {
            var t = e.target;
            return this !== t || e.isSimulated || e.isTrigger || "radio" !== t.type && "checkbox" !== t.type ? e.handleObj.handler.apply(this, arguments) : void 0;
        },
        teardown: function() {
            return S.event.remove(this, "._change"), !de.test(this.nodeName);
        }
    }), g.focusin || S.each({
        focus: "focusin",
        blur: "focusout"
    }, function(n, i) {
        var o = function(e) {
            S.event.simulate(i, e.target, S.event.fix(e));
        };
        S.event.special[i] = {
            setup: function() {
                var e = this.ownerDocument || this, t = S._data(e, i);
                t || e.addEventListener(n, o, !0), S._data(e, i, (t || 0) + 1);
            },
            teardown: function() {
                var e = this.ownerDocument || this, t = S._data(e, i) - 1;
                t ? S._data(e, i, t) : (e.removeEventListener(n, o, !0), S._removeData(e, i));
            }
        };
    }), S.fn.extend({
        on: function(e, t, n, i) {
            return we(this, e, t, n, i);
        },
        one: function(e, t, n, i) {
            return we(this, e, t, n, i, 1);
        },
        off: function(e, t, n) {
            var i, o;
            if (e && e.preventDefault && e.handleObj) return i = e.handleObj, S(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), 
            this;
            if ("object" == typeof e) {
                for (o in e) this.off(o, t, e[o]);
                return this;
            }
            return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = ye), 
            this.each(function() {
                S.event.remove(this, e, n, t);
            });
        },
        trigger: function(e, t) {
            return this.each(function() {
                S.event.trigger(e, t, this);
            });
        },
        triggerHandler: function(e, t) {
            var n = this[0];
            return n ? S.event.trigger(e, t, n, !0) : void 0;
        }
    });
    var xe = / jQuery\d+="(?:null|\d+)"/g, Ce = new RegExp("<(?:" + ie + ")[\\s/>]", "i"), Te = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi, Se = /<script|<style|<link/i, ke = /checked\s*(?:[^=]|=\s*.checked.)/i, Ee = /^true\/(.*)/, Ie = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g, Ne = oe(h).appendChild(h.createElement("div"));
    function Ae(e, t) {
        return S.nodeName(e, "table") && S.nodeName(11 !== t.nodeType ? t : t.firstChild, "tr") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e;
    }
    function De(e) {
        return e.type = (null !== S.find.attr(e, "type")) + "/" + e.type, e;
    }
    function je(e) {
        var t = Ee.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e;
    }
    function Pe(e, t) {
        if (1 === t.nodeType && S.hasData(e)) {
            var n, i, o, r = S._data(e), s = S._data(t, r), a = r.events;
            if (a) for (n in delete s.handle, s.events = {}, a) for (i = 0, o = a[n].length; i < o; i++) S.event.add(t, n, a[n][i]);
            s.data && (s.data = S.extend({}, s.data));
        }
    }
    function Le(e, t) {
        var n, i, o;
        if (1 === t.nodeType) {
            if (n = t.nodeName.toLowerCase(), !g.noCloneEvent && t[S.expando]) {
                for (i in (o = S._data(t)).events) S.removeEvent(t, i, o.handle);
                t.removeAttribute(S.expando);
            }
            "script" === n && t.text !== e.text ? (De(t).text = e.text, je(t)) : "object" === n ? (t.parentNode && (t.outerHTML = e.outerHTML), 
            g.html5Clone && e.innerHTML && !S.trim(t.innerHTML) && (t.innerHTML = e.innerHTML)) : "input" === n && Z.test(e.type) ? (t.defaultChecked = t.checked = e.checked, 
            t.value !== e.value && (t.value = e.value)) : "option" === n ? t.defaultSelected = t.selected = e.defaultSelected : "input" !== n && "textarea" !== n || (t.defaultValue = e.defaultValue);
        }
    }
    function $e(n, i, o, r) {
        i = m.apply([], i);
        var e, t, s, a, l, u, c = 0, p = n.length, d = p - 1, f = i[0], h = S.isFunction(f);
        if (h || 1 < p && "string" == typeof f && !g.checkClone && ke.test(f)) return n.each(function(e) {
            var t = n.eq(e);
            h && (i[0] = f.call(this, e, t.html())), $e(t, i, o, r);
        });
        if (p && (e = (u = pe(i, n[0].ownerDocument, !1, n, r)).firstChild, 1 === u.childNodes.length && (u = e), 
        e || r)) {
            for (s = (a = S.map(se(u, "script"), De)).length; c < p; c++) t = u, c !== d && (t = S.clone(t, !0, !0), 
            s && S.merge(a, se(t, "script"))), o.call(n[c], t, c);
            if (s) for (l = a[a.length - 1].ownerDocument, S.map(a, je), c = 0; c < s; c++) t = a[c], 
            te.test(t.type || "") && !S._data(t, "globalEval") && S.contains(l, t) && (t.src ? S._evalUrl && S._evalUrl(t.src) : S.globalEval((t.text || t.textContent || t.innerHTML || "").replace(Ie, "")));
            u = e = null;
        }
        return n;
    }
    function He(e, t, n) {
        for (var i, o = t ? S.filter(t, e) : e, r = 0; null != (i = o[r]); r++) n || 1 !== i.nodeType || S.cleanData(se(i)), 
        i.parentNode && (n && S.contains(i.ownerDocument, i) && ae(se(i, "script")), i.parentNode.removeChild(i));
        return e;
    }
    S.extend({
        htmlPrefilter: function(e) {
            return e.replace(Te, "<$1></$2>");
        },
        clone: function(e, t, n) {
            var i, o, r, s, a, l = S.contains(e.ownerDocument, e);
            if (g.html5Clone || S.isXMLDoc(e) || !Ce.test("<" + e.nodeName + ">") ? r = e.cloneNode(!0) : (Ne.innerHTML = e.outerHTML, 
            Ne.removeChild(r = Ne.firstChild)), !(g.noCloneEvent && g.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || S.isXMLDoc(e))) for (i = se(r), 
            a = se(e), s = 0; null != (o = a[s]); ++s) i[s] && Le(o, i[s]);
            if (t) if (n) for (a = a || se(e), i = i || se(r), s = 0; null != (o = a[s]); s++) Pe(o, i[s]); else Pe(e, r);
            return 0 < (i = se(r, "script")).length && ae(i, !l && se(e, "script")), i = a = o = null, 
            r;
        },
        cleanData: function(e, t) {
            for (var n, i, o, r, s = 0, a = S.expando, l = S.cache, u = g.attributes, c = S.event.special; null != (n = e[s]); s++) if ((t || W(n)) && (r = (o = n[a]) && l[o])) {
                if (r.events) for (i in r.events) c[i] ? S.event.remove(n, i) : S.removeEvent(n, i, r.handle);
                l[o] && (delete l[o], u || void 0 === n.removeAttribute ? n[a] = void 0 : n.removeAttribute(a), 
                p.push(o));
            }
        }
    }), S.fn.extend({
        domManip: $e,
        detach: function(e) {
            return He(this, e, !0);
        },
        remove: function(e) {
            return He(this, e);
        },
        text: function(e) {
            return K(this, function(e) {
                return void 0 === e ? S.text(this) : this.empty().append((this[0] && this[0].ownerDocument || h).createTextNode(e));
            }, null, e, arguments.length);
        },
        append: function() {
            return $e(this, arguments, function(e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || Ae(this, e).appendChild(e);
            });
        },
        prepend: function() {
            return $e(this, arguments, function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = Ae(this, e);
                    t.insertBefore(e, t.firstChild);
                }
            });
        },
        before: function() {
            return $e(this, arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this);
            });
        },
        after: function() {
            return $e(this, arguments, function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling);
            });
        },
        empty: function() {
            for (var e, t = 0; null != (e = this[t]); t++) {
                for (1 === e.nodeType && S.cleanData(se(e, !1)); e.firstChild; ) e.removeChild(e.firstChild);
                e.options && S.nodeName(e, "select") && (e.options.length = 0);
            }
            return this;
        },
        clone: function(e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function() {
                return S.clone(this, e, t);
            });
        },
        html: function(e) {
            return K(this, function(e) {
                var t = this[0] || {}, n = 0, i = this.length;
                if (void 0 === e) return 1 === t.nodeType ? t.innerHTML.replace(xe, "") : void 0;
                if ("string" == typeof e && !Se.test(e) && (g.htmlSerialize || !Ce.test(e)) && (g.leadingWhitespace || !ne.test(e)) && !re[(ee.exec(e) || [ "", "" ])[1].toLowerCase()]) {
                    e = S.htmlPrefilter(e);
                    try {
                        for (;n < i; n++) 1 === (t = this[n] || {}).nodeType && (S.cleanData(se(t, !1)), 
                        t.innerHTML = e);
                        t = 0;
                    } catch (e) {}
                }
                t && this.empty().append(e);
            }, null, e, arguments.length);
        },
        replaceWith: function() {
            var n = [];
            return $e(this, arguments, function(e) {
                var t = this.parentNode;
                S.inArray(this, n) < 0 && (S.cleanData(se(this)), t && t.replaceChild(e, this));
            }, n);
        }
    }), S.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function(e, s) {
        S.fn[e] = function(e) {
            for (var t, n = 0, i = [], o = S(e), r = o.length - 1; n <= r; n++) t = n === r ? this : this.clone(!0), 
            S(o[n])[s](t), a.apply(i, t.get());
            return this.pushStack(i);
        };
    });
    var qe, We = {
        HTML: "block",
        BODY: "block"
    };
    function Me(e, t) {
        var n = S(t.createElement(e)).appendTo(t.body), i = S.css(n[0], "display");
        return n.detach(), i;
    }
    function Oe(e) {
        var t = h, n = We[e];
        return n || ("none" !== (n = Me(e, t)) && n || ((t = ((qe = (qe || S("<iframe frameborder='0' width='0' height='0'/>")).appendTo(t.documentElement))[0].contentWindow || qe[0].contentDocument).document).write(), 
        t.close(), n = Me(e, t), qe.detach()), We[e] = n), n;
    }
    var _e = /^margin/, Fe = new RegExp("^(" + B + ")(?!px)[a-z%]+$", "i"), Re = function(e, t, n, i) {
        var o, r, s = {};
        for (r in t) s[r] = e.style[r], e.style[r] = t[r];
        for (r in o = n.apply(e, i || []), t) e.style[r] = s[r];
        return o;
    }, ze = h.documentElement;
    !function() {
        var i, o, r, s, a, l, u = h.createElement("div"), c = h.createElement("div");
        if (c.style) {
            function e() {
                var e, t, n = h.documentElement;
                n.appendChild(u), c.style.cssText = "-webkit-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", 
                i = r = l = !1, o = a = !0, T.getComputedStyle && (t = T.getComputedStyle(c), i = "1%" !== (t || {}).top, 
                l = "2px" === (t || {}).marginLeft, r = "4px" === (t || {
                    width: "4px"
                }).width, c.style.marginRight = "50%", o = "4px" === (t || {
                    marginRight: "4px"
                }).marginRight, (e = c.appendChild(h.createElement("div"))).style.cssText = c.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", 
                e.style.marginRight = e.style.width = "0", c.style.width = "1px", a = !parseFloat((T.getComputedStyle(e) || {}).marginRight), 
                c.removeChild(e)), c.style.display = "none", (s = 0 === c.getClientRects().length) && (c.style.display = "", 
                c.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", c.childNodes[0].style.borderCollapse = "separate", 
                (e = c.getElementsByTagName("td"))[0].style.cssText = "margin:0;border:0;padding:0;display:none", 
                (s = 0 === e[0].offsetHeight) && (e[0].style.display = "", e[1].style.display = "none", 
                s = 0 === e[0].offsetHeight)), n.removeChild(u);
            }
            c.style.cssText = "float:left;opacity:.5", g.opacity = "0.5" === c.style.opacity, 
            g.cssFloat = !!c.style.cssFloat, c.style.backgroundClip = "content-box", c.cloneNode(!0).style.backgroundClip = "", 
            g.clearCloneStyle = "content-box" === c.style.backgroundClip, (u = h.createElement("div")).style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", 
            c.innerHTML = "", u.appendChild(c), g.boxSizing = "" === c.style.boxSizing || "" === c.style.MozBoxSizing || "" === c.style.WebkitBoxSizing, 
            S.extend(g, {
                reliableHiddenOffsets: function() {
                    return null == i && e(), s;
                },
                boxSizingReliable: function() {
                    return null == i && e(), r;
                },
                pixelMarginRight: function() {
                    return null == i && e(), o;
                },
                pixelPosition: function() {
                    return null == i && e(), i;
                },
                reliableMarginRight: function() {
                    return null == i && e(), a;
                },
                reliableMarginLeft: function() {
                    return null == i && e(), l;
                }
            });
        }
    }();
    var Be, Xe, Ve = /^(top|right|bottom|left)$/;
    function Ue(e, t) {
        return {
            get: function() {
                return e() ? void delete this.get : (this.get = t).apply(this, arguments);
            }
        };
    }
    T.getComputedStyle ? (Be = function(e) {
        var t = e.ownerDocument.defaultView;
        return t && t.opener || (t = T), t.getComputedStyle(e);
    }, Xe = function(e, t, n) {
        var i, o, r, s, a = e.style;
        return "" !== (s = (n = n || Be(e)) ? n.getPropertyValue(t) || n[t] : void 0) && void 0 !== s || S.contains(e.ownerDocument, e) || (s = S.style(e, t)), 
        n && !g.pixelMarginRight() && Fe.test(s) && _e.test(t) && (i = a.width, o = a.minWidth, 
        r = a.maxWidth, a.minWidth = a.maxWidth = a.width = s, s = n.width, a.width = i, 
        a.minWidth = o, a.maxWidth = r), void 0 === s ? s : s + "";
    }) : ze.currentStyle && (Be = function(e) {
        return e.currentStyle;
    }, Xe = function(e, t, n) {
        var i, o, r, s, a = e.style;
        return null == (s = (n = n || Be(e)) ? n[t] : void 0) && a && a[t] && (s = a[t]), 
        Fe.test(s) && !Ve.test(t) && (i = a.left, (r = (o = e.runtimeStyle) && o.left) && (o.left = e.currentStyle.left), 
        a.left = "fontSize" === t ? "1em" : s, s = a.pixelLeft + "px", a.left = i, r && (o.left = r)), 
        void 0 === s ? s : s + "" || "auto";
    });
    var Ye = /alpha\([^)]*\)/i, Ge = /opacity\s*=\s*([^)]*)/i, Je = /^(none|table(?!-c[ea]).+)/, Qe = new RegExp("^(" + B + ")(.*)$", "i"), Ke = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
    }, Ze = {
        letterSpacing: "0",
        fontWeight: "400"
    }, et = [ "Webkit", "O", "Moz", "ms" ], tt = h.createElement("div").style;
    function nt(e) {
        if (e in tt) return e;
        for (var t = e.charAt(0).toUpperCase() + e.slice(1), n = et.length; n--; ) if ((e = et[n] + t) in tt) return e;
    }
    function it(e, t) {
        for (var n, i, o, r = [], s = 0, a = e.length; s < a; s++) (i = e[s]).style && (r[s] = S._data(i, "olddisplay"), 
        n = i.style.display, t ? (r[s] || "none" !== n || (i.style.display = ""), "" === i.style.display && U(i) && (r[s] = S._data(i, "olddisplay", Oe(i.nodeName)))) : (o = U(i), 
        (n && "none" !== n || !o) && S._data(i, "olddisplay", o ? n : S.css(i, "display"))));
        for (s = 0; s < a; s++) (i = e[s]).style && (t && "none" !== i.style.display && "" !== i.style.display || (i.style.display = t ? r[s] || "" : "none"));
        return e;
    }
    function ot(e, t, n) {
        var i = Qe.exec(t);
        return i ? Math.max(0, i[1] - (n || 0)) + (i[2] || "px") : t;
    }
    function rt(e, t, n, i, o) {
        for (var r = n === (i ? "border" : "content") ? 4 : "width" === t ? 1 : 0, s = 0; r < 4; r += 2) "margin" === n && (s += S.css(e, n + V[r], !0, o)), 
        i ? ("content" === n && (s -= S.css(e, "padding" + V[r], !0, o)), "margin" !== n && (s -= S.css(e, "border" + V[r] + "Width", !0, o))) : (s += S.css(e, "padding" + V[r], !0, o), 
        "padding" !== n && (s += S.css(e, "border" + V[r] + "Width", !0, o)));
        return s;
    }
    function st(e, t, n) {
        var i = !0, o = "width" === t ? e.offsetWidth : e.offsetHeight, r = Be(e), s = g.boxSizing && "border-box" === S.css(e, "boxSizing", !1, r);
        if (o <= 0 || null == o) {
            if (((o = Xe(e, t, r)) < 0 || null == o) && (o = e.style[t]), Fe.test(o)) return o;
            i = s && (g.boxSizingReliable() || o === e.style[t]), o = parseFloat(o) || 0;
        }
        return o + rt(e, t, n || (s ? "border" : "content"), i, r) + "px";
    }
    function at(e, t, n, i, o) {
        return new at.prototype.init(e, t, n, i, o);
    }
    S.extend({
        cssHooks: {
            opacity: {
                get: function(e, t) {
                    if (t) {
                        var n = Xe(e, "opacity");
                        return "" === n ? "1" : n;
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {
            float: g.cssFloat ? "cssFloat" : "styleFloat"
        },
        style: function(e, t, n, i) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var o, r, s, a = S.camelCase(t), l = e.style;
                if (t = S.cssProps[a] || (S.cssProps[a] = nt(a) || a), s = S.cssHooks[t] || S.cssHooks[a], 
                void 0 === n) return s && "get" in s && void 0 !== (o = s.get(e, !1, i)) ? o : l[t];
                if ("string" === (r = typeof n) && (o = X.exec(n)) && o[1] && (n = Y(e, t, o), r = "number"), 
                null != n && n == n && ("number" === r && (n += o && o[3] || (S.cssNumber[a] ? "" : "px")), 
                g.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), 
                !(s && "set" in s && void 0 === (n = s.set(e, n, i))))) try {
                    l[t] = n;
                } catch (e) {}
            }
        },
        css: function(e, t, n, i) {
            var o, r, s, a = S.camelCase(t);
            return t = S.cssProps[a] || (S.cssProps[a] = nt(a) || a), (s = S.cssHooks[t] || S.cssHooks[a]) && "get" in s && (r = s.get(e, !0, n)), 
            void 0 === r && (r = Xe(e, t, i)), "normal" === r && t in Ze && (r = Ze[t]), "" === n || n ? (o = parseFloat(r), 
            !0 === n || isFinite(o) ? o || 0 : r) : r;
        }
    }), S.each([ "height", "width" ], function(e, o) {
        S.cssHooks[o] = {
            get: function(e, t, n) {
                return t ? Je.test(S.css(e, "display")) && 0 === e.offsetWidth ? Re(e, Ke, function() {
                    return st(e, o, n);
                }) : st(e, o, n) : void 0;
            },
            set: function(e, t, n) {
                var i = n && Be(e);
                return ot(0, t, n ? rt(e, o, n, g.boxSizing && "border-box" === S.css(e, "boxSizing", !1, i), i) : 0);
            }
        };
    }), g.opacity || (S.cssHooks.opacity = {
        get: function(e, t) {
            return Ge.test((t && e.currentStyle ? e.currentStyle.filter : e.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : "";
        },
        set: function(e, t) {
            var n = e.style, i = e.currentStyle, o = S.isNumeric(t) ? "alpha(opacity=" + 100 * t + ")" : "", r = i && i.filter || n.filter || "";
            ((n.zoom = 1) <= t || "" === t) && "" === S.trim(r.replace(Ye, "")) && n.removeAttribute && (n.removeAttribute("filter"), 
            "" === t || i && !i.filter) || (n.filter = Ye.test(r) ? r.replace(Ye, o) : r + " " + o);
        }
    }), S.cssHooks.marginRight = Ue(g.reliableMarginRight, function(e, t) {
        return t ? Re(e, {
            display: "inline-block"
        }, Xe, [ e, "marginRight" ]) : void 0;
    }), S.cssHooks.marginLeft = Ue(g.reliableMarginLeft, function(e, t) {
        return t ? (parseFloat(Xe(e, "marginLeft")) || (S.contains(e.ownerDocument, e) ? e.getBoundingClientRect().left - Re(e, {
            marginLeft: 0
        }, function() {
            return e.getBoundingClientRect().left;
        }) : 0)) + "px" : void 0;
    }), S.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function(o, r) {
        S.cssHooks[o + r] = {
            expand: function(e) {
                for (var t = 0, n = {}, i = "string" == typeof e ? e.split(" ") : [ e ]; t < 4; t++) n[o + V[t] + r] = i[t] || i[t - 2] || i[0];
                return n;
            }
        }, _e.test(o) || (S.cssHooks[o + r].set = ot);
    }), S.fn.extend({
        css: function(e, t) {
            return K(this, function(e, t, n) {
                var i, o, r = {}, s = 0;
                if (S.isArray(t)) {
                    for (i = Be(e), o = t.length; s < o; s++) r[t[s]] = S.css(e, t[s], !1, i);
                    return r;
                }
                return void 0 !== n ? S.style(e, t, n) : S.css(e, t);
            }, e, t, 1 < arguments.length);
        },
        show: function() {
            return it(this, !0);
        },
        hide: function() {
            return it(this);
        },
        toggle: function(e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
                U(this) ? S(this).show() : S(this).hide();
            });
        }
    }), ((S.Tween = at).prototype = {
        constructor: at,
        init: function(e, t, n, i, o, r) {
            this.elem = e, this.prop = n, this.easing = o || S.easing._default, this.options = t, 
            this.start = this.now = this.cur(), this.end = i, this.unit = r || (S.cssNumber[n] ? "" : "px");
        },
        cur: function() {
            var e = at.propHooks[this.prop];
            return e && e.get ? e.get(this) : at.propHooks._default.get(this);
        },
        run: function(e) {
            var t, n = at.propHooks[this.prop];
            return this.options.duration ? this.pos = t = S.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, 
            this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), 
            n && n.set ? n.set(this) : at.propHooks._default.set(this), this;
        }
    }).init.prototype = at.prototype, (at.propHooks = {
        _default: {
            get: function(e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = S.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0;
            },
            set: function(e) {
                S.fx.step[e.prop] ? S.fx.step[e.prop](e) : 1 !== e.elem.nodeType || null == e.elem.style[S.cssProps[e.prop]] && !S.cssHooks[e.prop] ? e.elem[e.prop] = e.now : S.style(e.elem, e.prop, e.now + e.unit);
            }
        }
    }).scrollTop = at.propHooks.scrollLeft = {
        set: function(e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now);
        }
    }, S.easing = {
        linear: function(e) {
            return e;
        },
        swing: function(e) {
            return .5 - Math.cos(e * Math.PI) / 2;
        },
        _default: "swing"
    }, S.fx = at.prototype.init, S.fx.step = {};
    var lt, ut, ct, pt, dt, ft, ht, mt = /^(?:toggle|show|hide)$/, vt = /queueHooks$/;
    function gt() {
        return T.setTimeout(function() {
            lt = void 0;
        }), lt = S.now();
    }
    function yt(e, t) {
        var n, i = {
            height: e
        }, o = 0;
        for (t = t ? 1 : 0; o < 4; o += 2 - t) i["margin" + (n = V[o])] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i;
    }
    function bt(e, t, n) {
        for (var i, o = (wt.tweeners[t] || []).concat(wt.tweeners["*"]), r = 0, s = o.length; r < s; r++) if (i = o[r].call(n, t, e)) return i;
    }
    function wt(r, e, t) {
        var n, s, i = 0, o = wt.prefilters.length, a = S.Deferred().always(function() {
            delete l.elem;
        }), l = function() {
            if (s) return !1;
            for (var e = lt || gt(), t = Math.max(0, u.startTime + u.duration - e), n = 1 - (t / u.duration || 0), i = 0, o = u.tweens.length; i < o; i++) u.tweens[i].run(n);
            return a.notifyWith(r, [ u, n, t ]), n < 1 && o ? t : (a.resolveWith(r, [ u ]), 
            !1);
        }, u = a.promise({
            elem: r,
            props: S.extend({}, e),
            opts: S.extend(!0, {
                specialEasing: {},
                easing: S.easing._default
            }, t),
            originalProperties: e,
            originalOptions: t,
            startTime: lt || gt(),
            duration: t.duration,
            tweens: [],
            createTween: function(e, t) {
                var n = S.Tween(r, u.opts, e, t, u.opts.specialEasing[e] || u.opts.easing);
                return u.tweens.push(n), n;
            },
            stop: function(e) {
                var t = 0, n = e ? u.tweens.length : 0;
                if (s) return this;
                for (s = !0; t < n; t++) u.tweens[t].run(1);
                return e ? (a.notifyWith(r, [ u, 1, 0 ]), a.resolveWith(r, [ u, e ])) : a.rejectWith(r, [ u, e ]), 
                this;
            }
        }), c = u.props;
        for (function(e, t) {
            var n, i, o, r, s;
            for (n in e) if (o = t[i = S.camelCase(n)], r = e[n], S.isArray(r) && (o = r[1], 
            r = e[n] = r[0]), n !== i && (e[i] = r, delete e[n]), (s = S.cssHooks[i]) && "expand" in s) for (n in r = s.expand(r), 
            delete e[i], r) n in e || (e[n] = r[n], t[n] = o); else t[i] = o;
        }(c, u.opts.specialEasing); i < o; i++) if (n = wt.prefilters[i].call(u, r, c, u.opts)) return S.isFunction(n.stop) && (S._queueHooks(u.elem, u.opts.queue).stop = S.proxy(n.stop, n)), 
        n;
        return S.map(c, bt, u), S.isFunction(u.opts.start) && u.opts.start.call(r, u), S.fx.timer(S.extend(l, {
            elem: r,
            anim: u,
            queue: u.opts.queue
        })), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always);
    }
    S.Animation = S.extend(wt, {
        tweeners: {
            "*": [ function(e, t) {
                var n = this.createTween(e, t);
                return Y(n.elem, e, X.exec(t), n), n;
            } ]
        },
        tweener: function(e, t) {
            S.isFunction(e) ? (t = e, e = [ "*" ]) : e = e.match(L);
            for (var n, i = 0, o = e.length; i < o; i++) n = e[i], wt.tweeners[n] = wt.tweeners[n] || [], 
            wt.tweeners[n].unshift(t);
        },
        prefilters: [ function(t, e, n) {
            var i, o, r, s, a, l, u, c = this, p = {}, d = t.style, f = t.nodeType && U(t), h = S._data(t, "fxshow");
            for (i in n.queue || (null == (a = S._queueHooks(t, "fx")).unqueued && (a.unqueued = 0, 
            l = a.empty.fire, a.empty.fire = function() {
                a.unqueued || l();
            }), a.unqueued++, c.always(function() {
                c.always(function() {
                    a.unqueued--, S.queue(t, "fx").length || a.empty.fire();
                });
            })), 1 === t.nodeType && ("height" in e || "width" in e) && (n.overflow = [ d.overflow, d.overflowX, d.overflowY ], 
            "inline" === ("none" === (u = S.css(t, "display")) ? S._data(t, "olddisplay") || Oe(t.nodeName) : u) && "none" === S.css(t, "float") && (g.inlineBlockNeedsLayout && "inline" !== Oe(t.nodeName) ? d.zoom = 1 : d.display = "inline-block")), 
            n.overflow && (d.overflow = "hidden", g.shrinkWrapBlocks() || c.always(function() {
                d.overflow = n.overflow[0], d.overflowX = n.overflow[1], d.overflowY = n.overflow[2];
            })), e) if (o = e[i], mt.exec(o)) {
                if (delete e[i], r = r || "toggle" === o, o === (f ? "hide" : "show")) {
                    if ("show" !== o || !h || void 0 === h[i]) continue;
                    f = !0;
                }
                p[i] = h && h[i] || S.style(t, i);
            } else u = void 0;
            if (S.isEmptyObject(p)) "inline" === ("none" === u ? Oe(t.nodeName) : u) && (d.display = u); else for (i in h ? "hidden" in h && (f = h.hidden) : h = S._data(t, "fxshow", {}), 
            r && (h.hidden = !f), f ? S(t).show() : c.done(function() {
                S(t).hide();
            }), c.done(function() {
                var e;
                for (e in S._removeData(t, "fxshow"), p) S.style(t, e, p[e]);
            }), p) s = bt(f ? h[i] : 0, i, c), i in h || (h[i] = s.start, f && (s.end = s.start, 
            s.start = "width" === i || "height" === i ? 1 : 0));
        } ],
        prefilter: function(e, t) {
            t ? wt.prefilters.unshift(e) : wt.prefilters.push(e);
        }
    }), S.speed = function(e, t, n) {
        var i = e && "object" == typeof e ? S.extend({}, e) : {
            complete: n || !n && t || S.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !S.isFunction(t) && t
        };
        return i.duration = S.fx.off ? 0 : "number" == typeof i.duration ? i.duration : i.duration in S.fx.speeds ? S.fx.speeds[i.duration] : S.fx.speeds._default, 
        null != i.queue && !0 !== i.queue || (i.queue = "fx"), i.old = i.complete, i.complete = function() {
            S.isFunction(i.old) && i.old.call(this), i.queue && S.dequeue(this, i.queue);
        }, i;
    }, S.fn.extend({
        fadeTo: function(e, t, n, i) {
            return this.filter(U).css("opacity", 0).show().end().animate({
                opacity: t
            }, e, n, i);
        },
        animate: function(t, e, n, i) {
            var o = S.isEmptyObject(t), r = S.speed(e, n, i), s = function() {
                var e = wt(this, S.extend({}, t), r);
                (o || S._data(this, "finish")) && e.stop(!0);
            };
            return s.finish = s, o || !1 === r.queue ? this.each(s) : this.queue(r.queue, s);
        },
        stop: function(o, e, r) {
            var s = function(e) {
                var t = e.stop;
                delete e.stop, t(r);
            };
            return "string" != typeof o && (r = e, e = o, o = void 0), e && !1 !== o && this.queue(o || "fx", []), 
            this.each(function() {
                var e = !0, t = null != o && o + "queueHooks", n = S.timers, i = S._data(this);
                if (t) i[t] && i[t].stop && s(i[t]); else for (t in i) i[t] && i[t].stop && vt.test(t) && s(i[t]);
                for (t = n.length; t--; ) n[t].elem !== this || null != o && n[t].queue !== o || (n[t].anim.stop(r), 
                e = !1, n.splice(t, 1));
                !e && r || S.dequeue(this, o);
            });
        },
        finish: function(s) {
            return !1 !== s && (s = s || "fx"), this.each(function() {
                var e, t = S._data(this), n = t[s + "queue"], i = t[s + "queueHooks"], o = S.timers, r = n ? n.length : 0;
                for (t.finish = !0, S.queue(this, s, []), i && i.stop && i.stop.call(this, !0), 
                e = o.length; e--; ) o[e].elem === this && o[e].queue === s && (o[e].anim.stop(!0), 
                o.splice(e, 1));
                for (e = 0; e < r; e++) n[e] && n[e].finish && n[e].finish.call(this);
                delete t.finish;
            });
        }
    }), S.each([ "toggle", "show", "hide" ], function(e, i) {
        var o = S.fn[i];
        S.fn[i] = function(e, t, n) {
            return null == e || "boolean" == typeof e ? o.apply(this, arguments) : this.animate(yt(i, !0), e, t, n);
        };
    }), S.each({
        slideDown: yt("show"),
        slideUp: yt("hide"),
        slideToggle: yt("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function(e, i) {
        S.fn[e] = function(e, t, n) {
            return this.animate(i, e, t, n);
        };
    }), S.timers = [], S.fx.tick = function() {
        var e, t = S.timers, n = 0;
        for (lt = S.now(); n < t.length; n++) (e = t[n])() || t[n] !== e || t.splice(n--, 1);
        t.length || S.fx.stop(), lt = void 0;
    }, S.fx.timer = function(e) {
        S.timers.push(e), e() ? S.fx.start() : S.timers.pop();
    }, S.fx.interval = 13, S.fx.start = function() {
        ut || (ut = T.setInterval(S.fx.tick, S.fx.interval));
    }, S.fx.stop = function() {
        T.clearInterval(ut), ut = null;
    }, S.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, S.fn.delay = function(i, e) {
        return i = S.fx && S.fx.speeds[i] || i, e = e || "fx", this.queue(e, function(e, t) {
            var n = T.setTimeout(e, i);
            t.stop = function() {
                T.clearTimeout(n);
            };
        });
    }, pt = h.createElement("input"), dt = h.createElement("div"), ft = h.createElement("select"), 
    ht = ft.appendChild(h.createElement("option")), (dt = h.createElement("div")).setAttribute("className", "t"), 
    dt.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", 
    ct = dt.getElementsByTagName("a")[0], pt.setAttribute("type", "checkbox"), dt.appendChild(pt), 
    (ct = dt.getElementsByTagName("a")[0]).style.cssText = "top:1px", g.getSetAttribute = "t" !== dt.className, 
    g.style = /top/.test(ct.getAttribute("style")), g.hrefNormalized = "/a" === ct.getAttribute("href"), 
    g.checkOn = !!pt.value, g.optSelected = ht.selected, g.enctype = !!h.createElement("form").enctype, 
    ft.disabled = !0, g.optDisabled = !ht.disabled, (pt = h.createElement("input")).setAttribute("value", ""), 
    g.input = "" === pt.getAttribute("value"), pt.value = "t", pt.setAttribute("type", "radio"), 
    g.radioValue = "t" === pt.value;
    var xt = /\r/g, Ct = /[\x20\t\r\n\f]+/g;
    S.fn.extend({
        val: function(n) {
            var i, e, o, t = this[0];
            return arguments.length ? (o = S.isFunction(n), this.each(function(e) {
                var t;
                1 === this.nodeType && (null == (t = o ? n.call(this, e, S(this).val()) : n) ? t = "" : "number" == typeof t ? t += "" : S.isArray(t) && (t = S.map(t, function(e) {
                    return null == e ? "" : e + "";
                })), (i = S.valHooks[this.type] || S.valHooks[this.nodeName.toLowerCase()]) && "set" in i && void 0 !== i.set(this, t, "value") || (this.value = t));
            })) : t ? (i = S.valHooks[t.type] || S.valHooks[t.nodeName.toLowerCase()]) && "get" in i && void 0 !== (e = i.get(t, "value")) ? e : "string" == typeof (e = t.value) ? e.replace(xt, "") : null == e ? "" : e : void 0;
        }
    }), S.extend({
        valHooks: {
            option: {
                get: function(e) {
                    var t = S.find.attr(e, "value");
                    return null != t ? t : S.trim(S.text(e)).replace(Ct, " ");
                }
            },
            select: {
                get: function(e) {
                    for (var t, n, i = e.options, o = e.selectedIndex, r = "select-one" === e.type || o < 0, s = r ? null : [], a = r ? o + 1 : i.length, l = o < 0 ? a : r ? o : 0; l < a; l++) if (((n = i[l]).selected || l === o) && (g.optDisabled ? !n.disabled : null === n.getAttribute("disabled")) && (!n.parentNode.disabled || !S.nodeName(n.parentNode, "optgroup"))) {
                        if (t = S(n).val(), r) return t;
                        s.push(t);
                    }
                    return s;
                },
                set: function(e, t) {
                    for (var n, i, o = e.options, r = S.makeArray(t), s = o.length; s--; ) if (i = o[s], 
                    -1 < S.inArray(S.valHooks.option.get(i), r)) try {
                        i.selected = n = !0;
                    } catch (e) {
                        i.scrollHeight;
                    } else i.selected = !1;
                    return n || (e.selectedIndex = -1), o;
                }
            }
        }
    }), S.each([ "radio", "checkbox" ], function() {
        S.valHooks[this] = {
            set: function(e, t) {
                return S.isArray(t) ? e.checked = -1 < S.inArray(S(e).val(), t) : void 0;
            }
        }, g.checkOn || (S.valHooks[this].get = function(e) {
            return null === e.getAttribute("value") ? "on" : e.value;
        });
    });
    var Tt, St, kt = S.expr.attrHandle, Et = /^(?:checked|selected)$/i, It = g.getSetAttribute, Nt = g.input;
    S.fn.extend({
        attr: function(e, t) {
            return K(this, S.attr, e, t, 1 < arguments.length);
        },
        removeAttr: function(e) {
            return this.each(function() {
                S.removeAttr(this, e);
            });
        }
    }), S.extend({
        attr: function(e, t, n) {
            var i, o, r = e.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return void 0 === e.getAttribute ? S.prop(e, t, n) : (1 === r && S.isXMLDoc(e) || (t = t.toLowerCase(), 
            o = S.attrHooks[t] || (S.expr.match.bool.test(t) ? St : Tt)), void 0 !== n ? null === n ? void S.removeAttr(e, t) : o && "set" in o && void 0 !== (i = o.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), 
            n) : o && "get" in o && null !== (i = o.get(e, t)) ? i : null == (i = S.find.attr(e, t)) ? void 0 : i);
        },
        attrHooks: {
            type: {
                set: function(e, t) {
                    if (!g.radioValue && "radio" === t && S.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t;
                    }
                }
            }
        },
        removeAttr: function(e, t) {
            var n, i, o = 0, r = t && t.match(L);
            if (r && 1 === e.nodeType) for (;n = r[o++]; ) i = S.propFix[n] || n, S.expr.match.bool.test(n) ? Nt && It || !Et.test(n) ? e[i] = !1 : e[S.camelCase("default-" + n)] = e[i] = !1 : S.attr(e, n, ""), 
            e.removeAttribute(It ? n : i);
        }
    }), St = {
        set: function(e, t, n) {
            return !1 === t ? S.removeAttr(e, n) : Nt && It || !Et.test(n) ? e.setAttribute(!It && S.propFix[n] || n, n) : e[S.camelCase("default-" + n)] = e[n] = !0, 
            n;
        }
    }, S.each(S.expr.match.bool.source.match(/\w+/g), function(e, t) {
        var r = kt[t] || S.find.attr;
        Nt && It || !Et.test(t) ? kt[t] = function(e, t, n) {
            var i, o;
            return n || (o = kt[t], kt[t] = i, i = null != r(e, t, n) ? t.toLowerCase() : null, 
            kt[t] = o), i;
        } : kt[t] = function(e, t, n) {
            return n ? void 0 : e[S.camelCase("default-" + t)] ? t.toLowerCase() : null;
        };
    }), Nt && It || (S.attrHooks.value = {
        set: function(e, t, n) {
            return S.nodeName(e, "input") ? void (e.defaultValue = t) : Tt && Tt.set(e, t, n);
        }
    }), It || (Tt = {
        set: function(e, t, n) {
            var i = e.getAttributeNode(n);
            return i || e.setAttributeNode(i = e.ownerDocument.createAttribute(n)), i.value = t += "", 
            "value" === n || t === e.getAttribute(n) ? t : void 0;
        }
    }, kt.id = kt.name = kt.coords = function(e, t, n) {
        var i;
        return n ? void 0 : (i = e.getAttributeNode(t)) && "" !== i.value ? i.value : null;
    }, S.valHooks.button = {
        get: function(e, t) {
            var n = e.getAttributeNode(t);
            return n && n.specified ? n.value : void 0;
        },
        set: Tt.set
    }, S.attrHooks.contenteditable = {
        set: function(e, t, n) {
            Tt.set(e, "" !== t && t, n);
        }
    }, S.each([ "width", "height" ], function(e, n) {
        S.attrHooks[n] = {
            set: function(e, t) {
                return "" === t ? (e.setAttribute(n, "auto"), t) : void 0;
            }
        };
    })), g.style || (S.attrHooks.style = {
        get: function(e) {
            return e.style.cssText || void 0;
        },
        set: function(e, t) {
            return e.style.cssText = t + "";
        }
    });
    var At = /^(?:input|select|textarea|button|object)$/i, Dt = /^(?:a|area)$/i;
    S.fn.extend({
        prop: function(e, t) {
            return K(this, S.prop, e, t, 1 < arguments.length);
        },
        removeProp: function(e) {
            return e = S.propFix[e] || e, this.each(function() {
                try {
                    this[e] = void 0, delete this[e];
                } catch (e) {}
            });
        }
    }), S.extend({
        prop: function(e, t, n) {
            var i, o, r = e.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return 1 === r && S.isXMLDoc(e) || (t = S.propFix[t] || t, 
            o = S.propHooks[t]), void 0 !== n ? o && "set" in o && void 0 !== (i = o.set(e, n, t)) ? i : e[t] = n : o && "get" in o && null !== (i = o.get(e, t)) ? i : e[t];
        },
        propHooks: {
            tabIndex: {
                get: function(e) {
                    var t = S.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : At.test(e.nodeName) || Dt.test(e.nodeName) && e.href ? 0 : -1;
                }
            }
        },
        propFix: {
            for: "htmlFor",
            class: "className"
        }
    }), g.hrefNormalized || S.each([ "href", "src" ], function(e, t) {
        S.propHooks[t] = {
            get: function(e) {
                return e.getAttribute(t, 4);
            }
        };
    }), g.optSelected || (S.propHooks.selected = {
        get: function(e) {
            var t = e.parentNode;
            return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null;
        },
        set: function(e) {
            var t = e.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex);
        }
    }), S.each([ "tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable" ], function() {
        S.propFix[this.toLowerCase()] = this;
    }), g.enctype || (S.propFix.enctype = "encoding");
    var jt = /[\t\r\n\f]/g;
    function Pt(e) {
        return S.attr(e, "class") || "";
    }
    S.fn.extend({
        addClass: function(t) {
            var e, n, i, o, r, s, a, l = 0;
            if (S.isFunction(t)) return this.each(function(e) {
                S(this).addClass(t.call(this, e, Pt(this)));
            });
            if ("string" == typeof t && t) for (e = t.match(L) || []; n = this[l++]; ) if (o = Pt(n), 
            i = 1 === n.nodeType && (" " + o + " ").replace(jt, " ")) {
                for (s = 0; r = e[s++]; ) i.indexOf(" " + r + " ") < 0 && (i += r + " ");
                o !== (a = S.trim(i)) && S.attr(n, "class", a);
            }
            return this;
        },
        removeClass: function(t) {
            var e, n, i, o, r, s, a, l = 0;
            if (S.isFunction(t)) return this.each(function(e) {
                S(this).removeClass(t.call(this, e, Pt(this)));
            });
            if (!arguments.length) return this.attr("class", "");
            if ("string" == typeof t && t) for (e = t.match(L) || []; n = this[l++]; ) if (o = Pt(n), 
            i = 1 === n.nodeType && (" " + o + " ").replace(jt, " ")) {
                for (s = 0; r = e[s++]; ) for (;-1 < i.indexOf(" " + r + " "); ) i = i.replace(" " + r + " ", " ");
                o !== (a = S.trim(i)) && S.attr(n, "class", a);
            }
            return this;
        },
        toggleClass: function(o, t) {
            var r = typeof o;
            return "boolean" == typeof t && "string" === r ? t ? this.addClass(o) : this.removeClass(o) : S.isFunction(o) ? this.each(function(e) {
                S(this).toggleClass(o.call(this, e, Pt(this), t), t);
            }) : this.each(function() {
                var e, t, n, i;
                if ("string" === r) for (t = 0, n = S(this), i = o.match(L) || []; e = i[t++]; ) n.hasClass(e) ? n.removeClass(e) : n.addClass(e); else void 0 !== o && "boolean" !== r || ((e = Pt(this)) && S._data(this, "__className__", e), 
                S.attr(this, "class", e || !1 === o ? "" : S._data(this, "__className__") || ""));
            });
        },
        hasClass: function(e) {
            var t, n, i = 0;
            for (t = " " + e + " "; n = this[i++]; ) if (1 === n.nodeType && -1 < (" " + Pt(n) + " ").replace(jt, " ").indexOf(t)) return !0;
            return !1;
        }
    }), S.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(e, n) {
        S.fn[n] = function(e, t) {
            return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n);
        };
    }), S.fn.extend({
        hover: function(e, t) {
            return this.mouseenter(e).mouseleave(t || e);
        }
    });
    var Lt = T.location, $t = S.now(), Ht = /\?/, qt = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
    S.parseJSON = function(e) {
        if (T.JSON && T.JSON.parse) return T.JSON.parse(e + "");
        var o, r = null, t = S.trim(e + "");
        return t && !S.trim(t.replace(qt, function(e, t, n, i) {
            return o && t && (r = 0), 0 === r ? e : (o = n || t, r += !i - !n, "");
        })) ? Function("return " + t)() : S.error("Invalid JSON: " + e);
    }, S.parseXML = function(e) {
        var t;
        if (!e || "string" != typeof e) return null;
        try {
            T.DOMParser ? t = new T.DOMParser().parseFromString(e, "text/xml") : ((t = new T.ActiveXObject("Microsoft.XMLDOM")).async = "false", 
            t.loadXML(e));
        } catch (e) {
            t = void 0;
        }
        return t && t.documentElement && !t.getElementsByTagName("parsererror").length || S.error("Invalid XML: " + e), 
        t;
    };
    var Wt = /#.*$/, Mt = /([?&])_=[^&]*/, Ot = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm, _t = /^(?:GET|HEAD)$/, Ft = /^\/\//, Rt = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/, zt = {}, Bt = {}, Xt = "*/".concat("*"), Vt = Lt.href, Ut = Rt.exec(Vt.toLowerCase()) || [];
    function Yt(r) {
        return function(e, t) {
            "string" != typeof e && (t = e, e = "*");
            var n, i = 0, o = e.toLowerCase().match(L) || [];
            if (S.isFunction(t)) for (;n = o[i++]; ) "+" === n.charAt(0) ? (n = n.slice(1) || "*", 
            (r[n] = r[n] || []).unshift(t)) : (r[n] = r[n] || []).push(t);
        };
    }
    function Gt(t, o, r, s) {
        var a = {}, l = t === Bt;
        function u(e) {
            var i;
            return a[e] = !0, S.each(t[e] || [], function(e, t) {
                var n = t(o, r, s);
                return "string" != typeof n || l || a[n] ? l ? !(i = n) : void 0 : (o.dataTypes.unshift(n), 
                u(n), !1);
            }), i;
        }
        return u(o.dataTypes[0]) || !a["*"] && u("*");
    }
    function Jt(e, t) {
        var n, i, o = S.ajaxSettings.flatOptions || {};
        for (i in t) void 0 !== t[i] && ((o[i] ? e : n || (n = {}))[i] = t[i]);
        return n && S.extend(!0, e, n), e;
    }
    S.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: Vt,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(Ut[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Xt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": S.parseJSON,
                "text xml": S.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(e, t) {
            return t ? Jt(Jt(e, S.ajaxSettings), t) : Jt(S.ajaxSettings, e);
        },
        ajaxPrefilter: Yt(zt),
        ajaxTransport: Yt(Bt),
        ajax: function(e, t) {
            "object" == typeof e && (t = e, e = void 0), t = t || {};
            var n, i, c, p, d, f, h, o, m = S.ajaxSetup({}, t), v = m.context || m, g = m.context && (v.nodeType || v.jquery) ? S(v) : S.event, y = S.Deferred(), b = S.Callbacks("once memory"), w = m.statusCode || {}, r = {}, s = {}, x = 0, a = "canceled", C = {
                readyState: 0,
                getResponseHeader: function(e) {
                    var t;
                    if (2 === x) {
                        if (!o) for (o = {}; t = Ot.exec(p); ) o[t[1].toLowerCase()] = t[2];
                        t = o[e.toLowerCase()];
                    }
                    return null == t ? null : t;
                },
                getAllResponseHeaders: function() {
                    return 2 === x ? p : null;
                },
                setRequestHeader: function(e, t) {
                    var n = e.toLowerCase();
                    return x || (e = s[n] = s[n] || e, r[e] = t), this;
                },
                overrideMimeType: function(e) {
                    return x || (m.mimeType = e), this;
                },
                statusCode: function(e) {
                    var t;
                    if (e) if (x < 2) for (t in e) w[t] = [ w[t], e[t] ]; else C.always(e[C.status]);
                    return this;
                },
                abort: function(e) {
                    var t = e || a;
                    return h && h.abort(t), l(0, t), this;
                }
            };
            if (y.promise(C).complete = b.add, C.success = C.done, C.error = C.fail, m.url = ((e || m.url || Vt) + "").replace(Wt, "").replace(Ft, Ut[1] + "//"), 
            m.type = t.method || t.type || m.method || m.type, m.dataTypes = S.trim(m.dataType || "*").toLowerCase().match(L) || [ "" ], 
            null == m.crossDomain && (n = Rt.exec(m.url.toLowerCase()), m.crossDomain = !(!n || n[1] === Ut[1] && n[2] === Ut[2] && (n[3] || ("http:" === n[1] ? "80" : "443")) === (Ut[3] || ("http:" === Ut[1] ? "80" : "443")))), 
            m.data && m.processData && "string" != typeof m.data && (m.data = S.param(m.data, m.traditional)), 
            Gt(zt, m, t, C), 2 === x) return C;
            for (i in (f = S.event && m.global) && 0 == S.active++ && S.event.trigger("ajaxStart"), 
            m.type = m.type.toUpperCase(), m.hasContent = !_t.test(m.type), c = m.url, m.hasContent || (m.data && (c = m.url += (Ht.test(c) ? "&" : "?") + m.data, 
            delete m.data), !1 === m.cache && (m.url = Mt.test(c) ? c.replace(Mt, "$1_=" + $t++) : c + (Ht.test(c) ? "&" : "?") + "_=" + $t++)), 
            m.ifModified && (S.lastModified[c] && C.setRequestHeader("If-Modified-Since", S.lastModified[c]), 
            S.etag[c] && C.setRequestHeader("If-None-Match", S.etag[c])), (m.data && m.hasContent && !1 !== m.contentType || t.contentType) && C.setRequestHeader("Content-Type", m.contentType), 
            C.setRequestHeader("Accept", m.dataTypes[0] && m.accepts[m.dataTypes[0]] ? m.accepts[m.dataTypes[0]] + ("*" !== m.dataTypes[0] ? ", " + Xt + "; q=0.01" : "") : m.accepts["*"]), 
            m.headers) C.setRequestHeader(i, m.headers[i]);
            if (m.beforeSend && (!1 === m.beforeSend.call(v, C, m) || 2 === x)) return C.abort();
            for (i in a = "abort", {
                success: 1,
                error: 1,
                complete: 1
            }) C[i](m[i]);
            if (h = Gt(Bt, m, t, C)) {
                if (C.readyState = 1, f && g.trigger("ajaxSend", [ C, m ]), 2 === x) return C;
                m.async && 0 < m.timeout && (d = T.setTimeout(function() {
                    C.abort("timeout");
                }, m.timeout));
                try {
                    x = 1, h.send(r, l);
                } catch (e) {
                    if (!(x < 2)) throw e;
                    l(-1, e);
                }
            } else l(-1, "No Transport");
            function l(e, t, n, i) {
                var o, r, s, a, l, u = t;
                2 !== x && (x = 2, d && T.clearTimeout(d), h = void 0, p = i || "", C.readyState = 0 < e ? 4 : 0, 
                o = 200 <= e && e < 300 || 304 === e, n && (a = function(e, t, n) {
                    for (var i, o, r, s, a = e.contents, l = e.dataTypes; "*" === l[0]; ) l.shift(), 
                    void 0 === o && (o = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (o) for (s in a) if (a[s] && a[s].test(o)) {
                        l.unshift(s);
                        break;
                    }
                    if (l[0] in n) r = l[0]; else {
                        for (s in n) {
                            if (!l[0] || e.converters[s + " " + l[0]]) {
                                r = s;
                                break;
                            }
                            i || (i = s);
                        }
                        r = r || i;
                    }
                    return r ? (r !== l[0] && l.unshift(r), n[r]) : void 0;
                }(m, C, n)), a = function(e, t, n, i) {
                    var o, r, s, a, l, u = {}, c = e.dataTypes.slice();
                    if (c[1]) for (s in e.converters) u[s.toLowerCase()] = e.converters[s];
                    for (r = c.shift(); r; ) if (e.responseFields[r] && (n[e.responseFields[r]] = t), 
                    !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = r, r = c.shift()) if ("*" === r) r = l; else if ("*" !== l && l !== r) {
                        if (!(s = u[l + " " + r] || u["* " + r])) for (o in u) if ((a = o.split(" "))[1] === r && (s = u[l + " " + a[0]] || u["* " + a[0]])) {
                            !0 === s ? s = u[o] : !0 !== u[o] && (r = a[0], c.unshift(a[1]));
                            break;
                        }
                        if (!0 !== s) if (s && e.throws) t = s(t); else try {
                            t = s(t);
                        } catch (e) {
                            return {
                                state: "parsererror",
                                error: s ? e : "No conversion from " + l + " to " + r
                            };
                        }
                    }
                    return {
                        state: "success",
                        data: t
                    };
                }(m, a, C, o), o ? (m.ifModified && ((l = C.getResponseHeader("Last-Modified")) && (S.lastModified[c] = l), 
                (l = C.getResponseHeader("etag")) && (S.etag[c] = l)), 204 === e || "HEAD" === m.type ? u = "nocontent" : 304 === e ? u = "notmodified" : (u = a.state, 
                r = a.data, o = !(s = a.error))) : (s = u, !e && u || (u = "error", e < 0 && (e = 0))), 
                C.status = e, C.statusText = (t || u) + "", o ? y.resolveWith(v, [ r, u, C ]) : y.rejectWith(v, [ C, u, s ]), 
                C.statusCode(w), w = void 0, f && g.trigger(o ? "ajaxSuccess" : "ajaxError", [ C, m, o ? r : s ]), 
                b.fireWith(v, [ C, u ]), f && (g.trigger("ajaxComplete", [ C, m ]), --S.active || S.event.trigger("ajaxStop")));
            }
            return C;
        },
        getJSON: function(e, t, n) {
            return S.get(e, t, n, "json");
        },
        getScript: function(e, t) {
            return S.get(e, void 0, t, "script");
        }
    }), S.each([ "get", "post" ], function(e, o) {
        S[o] = function(e, t, n, i) {
            return S.isFunction(t) && (i = i || n, n = t, t = void 0), S.ajax(S.extend({
                url: e,
                type: o,
                dataType: i,
                data: t,
                success: n
            }, S.isPlainObject(e) && e));
        };
    }), S._evalUrl = function(e) {
        return S.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            throws: !0
        });
    }, S.fn.extend({
        wrapAll: function(t) {
            if (S.isFunction(t)) return this.each(function(e) {
                S(this).wrapAll(t.call(this, e));
            });
            if (this[0]) {
                var e = S(t, this[0].ownerDocument).eq(0).clone(!0);
                this[0].parentNode && e.insertBefore(this[0]), e.map(function() {
                    for (var e = this; e.firstChild && 1 === e.firstChild.nodeType; ) e = e.firstChild;
                    return e;
                }).append(this);
            }
            return this;
        },
        wrapInner: function(n) {
            return S.isFunction(n) ? this.each(function(e) {
                S(this).wrapInner(n.call(this, e));
            }) : this.each(function() {
                var e = S(this), t = e.contents();
                t.length ? t.wrapAll(n) : e.append(n);
            });
        },
        wrap: function(t) {
            var n = S.isFunction(t);
            return this.each(function(e) {
                S(this).wrapAll(n ? t.call(this, e) : t);
            });
        },
        unwrap: function() {
            return this.parent().each(function() {
                S.nodeName(this, "body") || S(this).replaceWith(this.childNodes);
            }).end();
        }
    }), S.expr.filters.hidden = function(e) {
        return g.reliableHiddenOffsets() ? e.offsetWidth <= 0 && e.offsetHeight <= 0 && !e.getClientRects().length : function(e) {
            if (!S.contains(e.ownerDocument || h, e)) return !0;
            for (;e && 1 === e.nodeType; ) {
                if ("none" === ((t = e).style && t.style.display || S.css(t, "display")) || "hidden" === e.type) return !0;
                e = e.parentNode;
            }
            var t;
            return !1;
        }(e);
    }, S.expr.filters.visible = function(e) {
        return !S.expr.filters.hidden(e);
    };
    var Qt = /%20/g, Kt = /\[\]$/, Zt = /\r?\n/g, en = /^(?:submit|button|image|reset|file)$/i, tn = /^(?:input|select|textarea|keygen)/i;
    function nn(n, e, i, o) {
        var t;
        if (S.isArray(e)) S.each(e, function(e, t) {
            i || Kt.test(n) ? o(n, t) : nn(n + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, i, o);
        }); else if (i || "object" !== S.type(e)) o(n, e); else for (t in e) nn(n + "[" + t + "]", e[t], i, o);
    }
    S.param = function(e, t) {
        var n, i = [], o = function(e, t) {
            t = S.isFunction(t) ? t() : null == t ? "" : t, i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t);
        };
        if (void 0 === t && (t = S.ajaxSettings && S.ajaxSettings.traditional), S.isArray(e) || e.jquery && !S.isPlainObject(e)) S.each(e, function() {
            o(this.name, this.value);
        }); else for (n in e) nn(n, e[n], t, o);
        return i.join("&").replace(Qt, "+");
    }, S.fn.extend({
        serialize: function() {
            return S.param(this.serializeArray());
        },
        serializeArray: function() {
            return this.map(function() {
                var e = S.prop(this, "elements");
                return e ? S.makeArray(e) : this;
            }).filter(function() {
                var e = this.type;
                return this.name && !S(this).is(":disabled") && tn.test(this.nodeName) && !en.test(e) && (this.checked || !Z.test(e));
            }).map(function(e, t) {
                var n = S(this).val();
                return null == n ? null : S.isArray(n) ? S.map(n, function(e) {
                    return {
                        name: t.name,
                        value: e.replace(Zt, "\r\n")
                    };
                }) : {
                    name: t.name,
                    value: n.replace(Zt, "\r\n")
                };
            }).get();
        }
    }), S.ajaxSettings.xhr = void 0 !== T.ActiveXObject ? function() {
        return this.isLocal ? ln() : 8 < h.documentMode ? an() : /^(get|post|head|put|delete|options)$/i.test(this.type) && an() || ln();
    } : an;
    var on = 0, rn = {}, sn = S.ajaxSettings.xhr();
    function an() {
        try {
            return new T.XMLHttpRequest();
        } catch (e) {}
    }
    function ln() {
        try {
            return new T.ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {}
    }
    T.attachEvent && T.attachEvent("onunload", function() {
        for (var e in rn) rn[e](void 0, !0);
    }), g.cors = !!sn && "withCredentials" in sn, (sn = g.ajax = !!sn) && S.ajaxTransport(function(l) {
        var u;
        if (!l.crossDomain || g.cors) return {
            send: function(e, r) {
                var t, s = l.xhr(), a = ++on;
                if (s.open(l.type, l.url, l.async, l.username, l.password), l.xhrFields) for (t in l.xhrFields) s[t] = l.xhrFields[t];
                for (t in l.mimeType && s.overrideMimeType && s.overrideMimeType(l.mimeType), l.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), 
                e) void 0 !== e[t] && s.setRequestHeader(t, e[t] + "");
                s.send(l.hasContent && l.data || null), u = function(e, t) {
                    var n, i, o;
                    if (u && (t || 4 === s.readyState)) if (delete rn[a], u = void 0, s.onreadystatechange = S.noop, 
                    t) 4 !== s.readyState && s.abort(); else {
                        o = {}, n = s.status, "string" == typeof s.responseText && (o.text = s.responseText);
                        try {
                            i = s.statusText;
                        } catch (e) {
                            i = "";
                        }
                        n || !l.isLocal || l.crossDomain ? 1223 === n && (n = 204) : n = o.text ? 200 : 404;
                    }
                    o && r(n, i, o, s.getAllResponseHeaders());
                }, l.async ? 4 === s.readyState ? T.setTimeout(u) : s.onreadystatechange = rn[a] = u : u();
            },
            abort: function() {
                u && u(void 0, !0);
            }
        };
    }), S.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function(e) {
                return S.globalEval(e), e;
            }
        }
    }), S.ajaxPrefilter("script", function(e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET", e.global = !1);
    }), S.ajaxTransport("script", function(t) {
        if (t.crossDomain) {
            var i, o = h.head || S("head")[0] || h.documentElement;
            return {
                send: function(e, n) {
                    (i = h.createElement("script")).async = !0, t.scriptCharset && (i.charset = t.scriptCharset), 
                    i.src = t.url, i.onload = i.onreadystatechange = function(e, t) {
                        (t || !i.readyState || /loaded|complete/.test(i.readyState)) && (i.onload = i.onreadystatechange = null, 
                        i.parentNode && i.parentNode.removeChild(i), i = null, t || n(200, "success"));
                    }, o.insertBefore(i, o.firstChild);
                },
                abort: function() {
                    i && i.onload(void 0, !0);
                }
            };
        }
    });
    var un = [], cn = /(=)\?(?=&|$)|\?\?/;
    S.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var e = un.pop() || S.expando + "_" + $t++;
            return this[e] = !0, e;
        }
    }), S.ajaxPrefilter("json jsonp", function(e, t, n) {
        var i, o, r, s = !1 !== e.jsonp && (cn.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && cn.test(e.data) && "data");
        return s || "jsonp" === e.dataTypes[0] ? (i = e.jsonpCallback = S.isFunction(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, 
        s ? e[s] = e[s].replace(cn, "$1" + i) : !1 !== e.jsonp && (e.url += (Ht.test(e.url) ? "&" : "?") + e.jsonp + "=" + i), 
        e.converters["script json"] = function() {
            return r || S.error(i + " was not called"), r[0];
        }, e.dataTypes[0] = "json", o = T[i], T[i] = function() {
            r = arguments;
        }, n.always(function() {
            void 0 === o ? S(T).removeProp(i) : T[i] = o, e[i] && (e.jsonpCallback = t.jsonpCallback, 
            un.push(i)), r && S.isFunction(o) && o(r[0]), r = o = void 0;
        }), "script") : void 0;
    }), S.parseHTML = function(e, t, n) {
        if (!e || "string" != typeof e) return null;
        "boolean" == typeof t && (n = t, t = !1), t = t || h;
        var i = x.exec(e), o = !n && [];
        return i ? [ t.createElement(i[1]) ] : (i = pe([ e ], t, o), o && o.length && S(o).remove(), 
        S.merge([], i.childNodes));
    };
    var pn = S.fn.load;
    function dn(e) {
        return S.isWindow(e) ? e : 9 === e.nodeType && (e.defaultView || e.parentWindow);
    }
    S.fn.load = function(e, t, n) {
        if ("string" != typeof e && pn) return pn.apply(this, arguments);
        var i, o, r, s = this, a = e.indexOf(" ");
        return -1 < a && (i = S.trim(e.slice(a, e.length)), e = e.slice(0, a)), S.isFunction(t) ? (n = t, 
        t = void 0) : t && "object" == typeof t && (o = "POST"), 0 < s.length && S.ajax({
            url: e,
            type: o || "GET",
            dataType: "html",
            data: t
        }).done(function(e) {
            r = arguments, s.html(i ? S("<div>").append(S.parseHTML(e)).find(i) : e);
        }).always(n && function(e, t) {
            s.each(function() {
                n.apply(this, r || [ e.responseText, t, e ]);
            });
        }), this;
    }, S.each([ "ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend" ], function(e, t) {
        S.fn[t] = function(e) {
            return this.on(t, e);
        };
    }), S.expr.filters.animated = function(t) {
        return S.grep(S.timers, function(e) {
            return t === e.elem;
        }).length;
    }, S.offset = {
        setOffset: function(e, t, n) {
            var i, o, r, s, a, l, u = S.css(e, "position"), c = S(e), p = {};
            "static" === u && (e.style.position = "relative"), a = c.offset(), r = S.css(e, "top"), 
            l = S.css(e, "left"), ("absolute" === u || "fixed" === u) && -1 < S.inArray("auto", [ r, l ]) ? (s = (i = c.position()).top, 
            o = i.left) : (s = parseFloat(r) || 0, o = parseFloat(l) || 0), S.isFunction(t) && (t = t.call(e, n, S.extend({}, a))), 
            null != t.top && (p.top = t.top - a.top + s), null != t.left && (p.left = t.left - a.left + o), 
            "using" in t ? t.using.call(e, p) : c.css(p);
        }
    }, S.fn.extend({
        offset: function(t) {
            if (arguments.length) return void 0 === t ? this : this.each(function(e) {
                S.offset.setOffset(this, t, e);
            });
            var e, n, i = {
                top: 0,
                left: 0
            }, o = this[0], r = o && o.ownerDocument;
            return r ? (e = r.documentElement, S.contains(e, o) ? (void 0 !== o.getBoundingClientRect && (i = o.getBoundingClientRect()), 
            n = dn(r), {
                top: i.top + (n.pageYOffset || e.scrollTop) - (e.clientTop || 0),
                left: i.left + (n.pageXOffset || e.scrollLeft) - (e.clientLeft || 0)
            }) : i) : void 0;
        },
        position: function() {
            if (this[0]) {
                var e, t, n = {
                    top: 0,
                    left: 0
                }, i = this[0];
                return "fixed" === S.css(i, "position") ? t = i.getBoundingClientRect() : (e = this.offsetParent(), 
                t = this.offset(), S.nodeName(e[0], "html") || (n = e.offset()), n.top += S.css(e[0], "borderTopWidth", !0), 
                n.left += S.css(e[0], "borderLeftWidth", !0)), {
                    top: t.top - n.top - S.css(i, "marginTop", !0),
                    left: t.left - n.left - S.css(i, "marginLeft", !0)
                };
            }
        },
        offsetParent: function() {
            return this.map(function() {
                for (var e = this.offsetParent; e && !S.nodeName(e, "html") && "static" === S.css(e, "position"); ) e = e.offsetParent;
                return e || ze;
            });
        }
    }), S.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function(t, o) {
        var r = /Y/.test(o);
        S.fn[t] = function(e) {
            return K(this, function(e, t, n) {
                var i = dn(e);
                return void 0 === n ? i ? o in i ? i[o] : i.document.documentElement[t] : e[t] : void (i ? i.scrollTo(r ? S(i).scrollLeft() : n, r ? n : S(i).scrollTop()) : e[t] = n);
            }, t, e, arguments.length, null);
        };
    }), S.each([ "top", "left" ], function(e, n) {
        S.cssHooks[n] = Ue(g.pixelPosition, function(e, t) {
            return t ? (t = Xe(e, n), Fe.test(t) ? S(e).position()[n] + "px" : t) : void 0;
        });
    }), S.each({
        Height: "height",
        Width: "width"
    }, function(r, s) {
        S.each({
            padding: "inner" + r,
            content: s,
            "": "outer" + r
        }, function(i, e) {
            S.fn[e] = function(e, t) {
                var n = arguments.length && (i || "boolean" != typeof e), o = i || (!0 === e || !0 === t ? "margin" : "border");
                return K(this, function(e, t, n) {
                    var i;
                    return S.isWindow(e) ? e.document.documentElement["client" + r] : 9 === e.nodeType ? (i = e.documentElement, 
                    Math.max(e.body["scroll" + r], i["scroll" + r], e.body["offset" + r], i["offset" + r], i["client" + r])) : void 0 === n ? S.css(e, t, o) : S.style(e, t, n, o);
                }, s, n ? e : void 0, n, null);
            };
        });
    }), S.fn.extend({
        bind: function(e, t, n) {
            return this.on(e, null, t, n);
        },
        unbind: function(e, t) {
            return this.off(e, null, t);
        },
        delegate: function(e, t, n, i) {
            return this.on(t, e, n, i);
        },
        undelegate: function(e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n);
        }
    }), S.fn.size = function() {
        return this.length;
    }, S.fn.andSelf = S.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function() {
        return S;
    });
    var fn = T.jQuery, hn = T.$;
    return S.noConflict = function(e) {
        return T.$ === S && (T.$ = hn), e && T.jQuery === S && (T.jQuery = fn), S;
    }, e || (T.jQuery = T.$ = S), S;
}), jQuery.noConflict(), "function" != typeof Object.create && (Object.create = function(e) {
    function t() {}
    return t.prototype = e, new t();
}), function(l, u, c) {
    var n = {
        init: function(e, t) {
            var n = this;
            n.$elem = l(t), n.options = l.extend({}, l.fn.owlCarousel.options, n.$elem.data(), e), 
            n.userOptions = e, n.loadContent();
        },
        loadContent: function() {
            var e, i = this;
            "function" == typeof i.options.beforeInit && i.options.beforeInit.apply(this, [ i.$elem ]), 
            "string" == typeof i.options.jsonPath ? (e = i.options.jsonPath, l.getJSON(e, function(e) {
                var t, n = "";
                if ("function" == typeof i.options.jsonSuccess) i.options.jsonSuccess.apply(this, [ e ]); else {
                    for (t in e.owl) e.owl.hasOwnProperty(t) && (n += e.owl[t].item);
                    i.$elem.html(n);
                }
                i.logIn();
            })) : i.logIn();
        },
        logIn: function() {
            var e = this;
            e.$elem.data("owl-originalStyles", e.$elem.attr("style")), e.$elem.data("owl-originalClasses", e.$elem.attr("class")), 
            e.$elem.css({
                opacity: 0
            }), e.orignalItems = e.options.items, e.checkBrowser(), e.wrapperWidth = 0, e.checkVisible = null, 
            e.setVars();
        },
        setVars: function() {
            var e = this;
            if (0 === e.$elem.children().length) return !1;
            e.baseClass(), e.eventTypes(), e.$userItems = e.$elem.children(), e.itemsAmount = e.$userItems.length, 
            e.wrapItems(), e.$owlItems = e.$elem.find(".owl-item"), e.$owlWrapper = e.$elem.find(".owl-wrapper"), 
            e.playDirection = "next", e.prevItem = 0, e.prevArr = [ 0 ], e.currentItem = 0, 
            e.customEvents(), e.onStartup();
        },
        onStartup: function() {
            var e = this;
            e.updateItems(), e.calculateAll(), e.buildControls(), e.updateControls(), e.response(), 
            e.moveEvents(), e.stopOnHover(), e.owlStatus(), !1 !== e.options.transitionStyle && e.transitionTypes(e.options.transitionStyle), 
            !0 === e.options.autoPlay && (e.options.autoPlay = 5e3), e.play(), e.$elem.find(".owl-wrapper").css("display", "block"), 
            e.$elem.is(":visible") ? e.$elem.css("opacity", 1) : e.watchVisibility(), e.onstartup = !1, 
            e.eachMoveUpdate(), "function" == typeof e.options.afterInit && e.options.afterInit.apply(this, [ e.$elem ]);
        },
        eachMoveUpdate: function() {
            var e = this;
            !0 === e.options.lazyLoad && e.lazyLoad(), !0 === e.options.autoHeight && e.autoHeight(), 
            e.onVisibleItems(), "function" == typeof e.options.afterAction && e.options.afterAction.apply(this, [ e.$elem ]);
        },
        updateVars: function() {
            var e = this;
            "function" == typeof e.options.beforeUpdate && e.options.beforeUpdate.apply(this, [ e.$elem ]), 
            e.watchVisibility(), e.updateItems(), e.calculateAll(), e.updatePosition(), e.updateControls(), 
            e.eachMoveUpdate(), "function" == typeof e.options.afterUpdate && e.options.afterUpdate.apply(this, [ e.$elem ]);
        },
        reload: function() {
            var e = this;
            u.setTimeout(function() {
                e.updateVars();
            }, 0);
        },
        watchVisibility: function() {
            var e = this;
            if (!1 !== e.$elem.is(":visible")) return !1;
            e.$elem.css({
                opacity: 0
            }), u.clearInterval(e.autoPlayInterval), u.clearInterval(e.checkVisible), e.checkVisible = u.setInterval(function() {
                e.$elem.is(":visible") && (e.reload(), e.$elem.animate({
                    opacity: 1
                }, 200), u.clearInterval(e.checkVisible));
            }, 500);
        },
        wrapItems: function() {
            var e = this;
            e.$userItems.wrapAll('<div class="owl-wrapper">').wrap('<div class="owl-item"></div>'), 
            e.$elem.find(".owl-wrapper").wrap('<div class="owl-wrapper-outer">'), e.wrapperOuter = e.$elem.find(".owl-wrapper-outer"), 
            e.$elem.css("display", "block");
        },
        baseClass: function() {
            var e = this, t = e.$elem.hasClass(e.options.baseClass), n = e.$elem.hasClass(e.options.theme);
            t || e.$elem.addClass(e.options.baseClass), n || e.$elem.addClass(e.options.theme);
        },
        updateItems: function() {
            var e, t, n = this;
            if (!1 === n.options.responsive) return !1;
            if (!0 === n.options.singleItem) return n.options.items = n.orignalItems = 1, n.options.itemsCustom = !1, 
            n.options.itemsDesktop = !1, n.options.itemsDesktopSmall = !1, n.options.itemsTablet = !1, 
            n.options.itemsTabletSmall = !1, n.options.itemsMobile = !1;
            if ((e = l(n.options.responsiveBaseWidth).width()) > (n.options.itemsDesktop[0] || n.orignalItems) && (n.options.items = n.orignalItems), 
            !1 !== n.options.itemsCustom) for (n.options.itemsCustom.sort(function(e, t) {
                return e[0] - t[0];
            }), t = 0; t < n.options.itemsCustom.length; t += 1) n.options.itemsCustom[t][0] <= e && (n.options.items = n.options.itemsCustom[t][1]); else e <= n.options.itemsDesktop[0] && !1 !== n.options.itemsDesktop && (n.options.items = n.options.itemsDesktop[1]), 
            e <= n.options.itemsDesktopSmall[0] && !1 !== n.options.itemsDesktopSmall && (n.options.items = n.options.itemsDesktopSmall[1]), 
            e <= n.options.itemsTablet[0] && !1 !== n.options.itemsTablet && (n.options.items = n.options.itemsTablet[1]), 
            e <= n.options.itemsTabletSmall[0] && !1 !== n.options.itemsTabletSmall && (n.options.items = n.options.itemsTabletSmall[1]), 
            e <= n.options.itemsMobile[0] && !1 !== n.options.itemsMobile && (n.options.items = n.options.itemsMobile[1]);
            n.options.items > n.itemsAmount && !0 === n.options.itemsScaleUp && (n.options.items = n.itemsAmount);
        },
        response: function() {
            var e, t, n = this;
            if (!0 !== n.options.responsive) return !1;
            t = l(u).width(), n.resizer = function() {
                l(u).width() !== t && (!1 !== n.options.autoPlay && u.clearInterval(n.autoPlayInterval), 
                u.clearTimeout(e), e = u.setTimeout(function() {
                    t = l(u).width(), n.updateVars();
                }, n.options.responsiveRefreshRate));
            }, l(u).resize(n.resizer);
        },
        updatePosition: function() {
            this.jumpTo(this.currentItem), !1 !== this.options.autoPlay && this.checkAp();
        },
        appendItemsSizes: function() {
            var n = this, i = 0, o = n.itemsAmount - n.options.items;
            n.$owlItems.each(function(e) {
                var t = l(this);
                t.css({
                    width: n.itemWidth
                }).data("owl-item", Number(e)), e % n.options.items != 0 && e !== o || o < e || (i += 1), 
                t.data("owl-roundPages", i);
            });
        },
        appendWrapperSizes: function() {
            var e = this.$owlItems.length * this.itemWidth;
            this.$owlWrapper.css({
                width: 2 * e,
                left: 0
            }), this.appendItemsSizes();
        },
        calculateAll: function() {
            this.calculateWidth(), this.appendWrapperSizes(), this.loops(), this.max();
        },
        calculateWidth: function() {
            this.itemWidth = Math.round(this.$elem.width() / this.options.items);
        },
        max: function() {
            var e = this, t = -1 * (e.itemsAmount * e.itemWidth - e.options.items * e.itemWidth);
            return e.options.items > e.itemsAmount ? (t = e.maximumItem = 0, e.maximumPixels = 0) : (e.maximumItem = e.itemsAmount - e.options.items, 
            e.maximumPixels = t), t;
        },
        min: function() {
            return 0;
        },
        loops: function() {
            var e, t, n = this, i = 0, o = 0;
            for (n.positionsInArray = [ 0 ], n.pagesInArray = [], e = 0; e < n.itemsAmount; e += 1) o += n.itemWidth, 
            n.positionsInArray.push(-o), !0 === n.options.scrollPerPage && (t = l(n.$owlItems[e]).data("owl-roundPages")) !== i && (n.pagesInArray[i] = n.positionsInArray[e], 
            i = t);
        },
        buildControls: function() {
            var e = this;
            !0 !== e.options.navigation && !0 !== e.options.pagination || (e.owlControls = l('<div class="owl-controls"/>').toggleClass("clickable", !e.browser.isTouch).appendTo(e.$elem)), 
            !0 === e.options.pagination && e.buildPagination(), !0 === e.options.navigation && e.buildButtons();
        },
        buildButtons: function() {
            var t = this, e = l('<div class="owl-buttons"/>');
            t.owlControls.append(e), t.buttonPrev = l("<div/>", {
                class: "owl-prev",
                html: t.options.navigationText[0] || ""
            }), t.buttonNext = l("<div/>", {
                class: "owl-next",
                html: t.options.navigationText[1] || ""
            }), e.append(t.buttonPrev).append(t.buttonNext), e.on("touchstart.owlControls mousedown.owlControls", 'div[class^="owl"]', function(e) {
                e.preventDefault();
            }), e.on("touchend.owlControls mouseup.owlControls", 'div[class^="owl"]', function(e) {
                e.preventDefault(), l(this).hasClass("owl-next") ? t.next() : t.prev();
            });
        },
        buildPagination: function() {
            var t = this;
            t.paginationWrapper = l('<div class="owl-pagination"/>'), t.owlControls.append(t.paginationWrapper), 
            t.paginationWrapper.on("touchend.owlControls mouseup.owlControls", ".owl-page", function(e) {
                e.preventDefault(), Number(l(this).data("owl-page")) !== t.currentItem && t.goTo(Number(l(this).data("owl-page")), !0);
            });
        },
        updatePagination: function() {
            var e, t, n, i, o, r, s = this;
            if (!1 === s.options.pagination) return !1;
            for (s.paginationWrapper.html(""), e = 0, t = s.itemsAmount - s.itemsAmount % s.options.items, 
            i = 0; i < s.itemsAmount; i += 1) i % s.options.items == 0 && (e += 1, t === i && (n = s.itemsAmount - s.options.items), 
            o = l("<div/>", {
                class: "owl-page"
            }), r = l("<span></span>", {
                text: !0 === s.options.paginationNumbers ? e : "",
                class: !0 === s.options.paginationNumbers ? "owl-numbers" : ""
            }), o.append(r), o.data("owl-page", t === i ? n : i), o.data("owl-roundPages", e), 
            s.paginationWrapper.append(o));
            s.checkPagination();
        },
        checkPagination: function() {
            var e = this;
            if (!1 === e.options.pagination) return !1;
            e.paginationWrapper.find(".owl-page").each(function() {
                l(this).data("owl-roundPages") === l(e.$owlItems[e.currentItem]).data("owl-roundPages") && (e.paginationWrapper.find(".owl-page").removeClass("active"), 
                l(this).addClass("active"));
            });
        },
        checkNavigation: function() {
            var e = this;
            if (!1 === e.options.navigation) return !1;
            !1 === e.options.rewindNav && (0 === e.currentItem && 0 === e.maximumItem ? (e.buttonPrev.addClass("disabled"), 
            e.buttonNext.addClass("disabled")) : 0 === e.currentItem && 0 !== e.maximumItem ? (e.buttonPrev.addClass("disabled"), 
            e.buttonNext.removeClass("disabled")) : e.currentItem === e.maximumItem ? (e.buttonPrev.removeClass("disabled"), 
            e.buttonNext.addClass("disabled")) : 0 !== e.currentItem && e.currentItem !== e.maximumItem && (e.buttonPrev.removeClass("disabled"), 
            e.buttonNext.removeClass("disabled")));
        },
        updateControls: function() {
            var e = this;
            e.updatePagination(), e.checkNavigation(), e.owlControls && (e.options.items >= e.itemsAmount ? e.owlControls.hide() : e.owlControls.show());
        },
        destroyControls: function() {
            this.owlControls && this.owlControls.remove();
        },
        next: function(e) {
            var t = this;
            if (t.isTransition) return !1;
            if (t.currentItem += !0 === t.options.scrollPerPage ? t.options.items : 1, t.currentItem > t.maximumItem + (!0 === t.options.scrollPerPage ? t.options.items - 1 : 0)) {
                if (!0 !== t.options.rewindNav) return t.currentItem = t.maximumItem, !1;
                t.currentItem = 0, e = "rewind";
            }
            t.goTo(t.currentItem, e);
        },
        prev: function(e) {
            var t = this;
            if (t.isTransition) return !1;
            if (!0 === t.options.scrollPerPage && 0 < t.currentItem && t.currentItem < t.options.items ? t.currentItem = 0 : t.currentItem -= !0 === t.options.scrollPerPage ? t.options.items : 1, 
            t.currentItem < 0) {
                if (!0 !== t.options.rewindNav) return t.currentItem = 0, !1;
                t.currentItem = t.maximumItem, e = "rewind";
            }
            t.goTo(t.currentItem, e);
        },
        goTo: function(e, t, n) {
            var i, o = this;
            return !o.isTransition && ("function" == typeof o.options.beforeMove && o.options.beforeMove.apply(this, [ o.$elem ]), 
            e >= o.maximumItem ? e = o.maximumItem : e <= 0 && (e = 0), o.currentItem = o.owl.currentItem = e, 
            !1 !== o.options.transitionStyle && "drag" !== n && 1 === o.options.items && !0 === o.browser.support3d ? (o.swapSpeed(0), 
            !0 === o.browser.support3d ? o.transition3d(o.positionsInArray[e]) : o.css2slide(o.positionsInArray[e], 1), 
            o.afterGo(), o.singleItemTransition(), !1) : (i = o.positionsInArray[e], !0 === o.browser.support3d ? (!(o.isCss3Finish = !1) === t ? (o.swapSpeed("paginationSpeed"), 
            u.setTimeout(function() {
                o.isCss3Finish = !0;
            }, o.options.paginationSpeed)) : "rewind" === t ? (o.swapSpeed(o.options.rewindSpeed), 
            u.setTimeout(function() {
                o.isCss3Finish = !0;
            }, o.options.rewindSpeed)) : (o.swapSpeed("slideSpeed"), u.setTimeout(function() {
                o.isCss3Finish = !0;
            }, o.options.slideSpeed)), o.transition3d(i)) : !0 === t ? o.css2slide(i, o.options.paginationSpeed) : "rewind" === t ? o.css2slide(i, o.options.rewindSpeed) : o.css2slide(i, o.options.slideSpeed), 
            void o.afterGo()));
        },
        jumpTo: function(e) {
            var t = this;
            "function" == typeof t.options.beforeMove && t.options.beforeMove.apply(this, [ t.$elem ]), 
            e >= t.maximumItem || -1 === e ? e = t.maximumItem : e <= 0 && (e = 0), t.swapSpeed(0), 
            !0 === t.browser.support3d ? t.transition3d(t.positionsInArray[e]) : t.css2slide(t.positionsInArray[e], 1), 
            t.currentItem = t.owl.currentItem = e, t.afterGo();
        },
        afterGo: function() {
            var e = this;
            e.prevArr.push(e.currentItem), e.prevItem = e.owl.prevItem = e.prevArr[e.prevArr.length - 2], 
            e.prevArr.shift(0), e.prevItem !== e.currentItem && (e.checkPagination(), e.checkNavigation(), 
            e.eachMoveUpdate(), !1 !== e.options.autoPlay && e.checkAp()), "function" == typeof e.options.afterMove && e.prevItem !== e.currentItem && e.options.afterMove.apply(this, [ e.$elem ]);
        },
        stop: function() {
            this.apStatus = "stop", u.clearInterval(this.autoPlayInterval);
        },
        checkAp: function() {
            "stop" !== this.apStatus && this.play();
        },
        play: function() {
            var e = this;
            if (!(e.apStatus = "play") === e.options.autoPlay) return !1;
            u.clearInterval(e.autoPlayInterval), e.autoPlayInterval = u.setInterval(function() {
                e.next(!0);
            }, e.options.autoPlay);
        },
        swapSpeed: function(e) {
            var t = this;
            "slideSpeed" === e ? t.$owlWrapper.css(t.addCssSpeed(t.options.slideSpeed)) : "paginationSpeed" === e ? t.$owlWrapper.css(t.addCssSpeed(t.options.paginationSpeed)) : "string" != typeof e && t.$owlWrapper.css(t.addCssSpeed(e));
        },
        addCssSpeed: function(e) {
            return {
                "-webkit-transition": "all " + e + "ms ease",
                "-moz-transition": "all " + e + "ms ease",
                "-o-transition": "all " + e + "ms ease",
                transition: "all " + e + "ms ease"
            };
        },
        removeTransition: function() {
            return {
                "-webkit-transition": "",
                "-moz-transition": "",
                "-o-transition": "",
                transition: ""
            };
        },
        doTranslate: function(e) {
            return {
                "-webkit-transform": "translate3d(" + e + "px, 0px, 0px)",
                "-moz-transform": "translate3d(" + e + "px, 0px, 0px)",
                "-o-transform": "translate3d(" + e + "px, 0px, 0px)",
                "-ms-transform": "translate3d(" + e + "px, 0px, 0px)",
                transform: "translate3d(" + e + "px, 0px,0px)"
            };
        },
        transition3d: function(e) {
            this.$owlWrapper.css(this.doTranslate(e));
        },
        css2move: function(e) {
            this.$owlWrapper.css({
                left: e
            });
        },
        css2slide: function(e, t) {
            var n = this;
            n.isCssFinish = !1, n.$owlWrapper.stop(!0, !0).animate({
                left: e
            }, {
                duration: t || n.options.slideSpeed,
                complete: function() {
                    n.isCssFinish = !0;
                }
            });
        },
        checkBrowser: function() {
            var e, t, n, i, o = "translate3d(0px, 0px, 0px)", r = c.createElement("div");
            r.style.cssText = "  -moz-transform:" + o + "; -ms-transform:" + o + "; -o-transform:" + o + "; -webkit-transform:" + o + "; transform:" + o, 
            e = /translate3d\(0px, 0px, 0px\)/g, n = null !== (t = r.style.cssText.match(e)) && 1 === t.length, 
            i = "ontouchstart" in u || u.navigator.msMaxTouchPoints, this.browser = {
                support3d: n,
                isTouch: i
            };
        },
        moveEvents: function() {
            !1 === this.options.mouseDrag && !1 === this.options.touchDrag || (this.gestures(), 
            this.disabledEvents());
        },
        eventTypes: function() {
            var e = this, t = [ "s", "e", "x" ];
            e.ev_types = {}, !0 === e.options.mouseDrag && !0 === e.options.touchDrag ? t = [ "touchstart.owl mousedown.owl", "touchmove.owl mousemove.owl", "touchend.owl touchcancel.owl mouseup.owl" ] : !1 === e.options.mouseDrag && !0 === e.options.touchDrag ? t = [ "touchstart.owl", "touchmove.owl", "touchend.owl touchcancel.owl" ] : !0 === e.options.mouseDrag && !1 === e.options.touchDrag && (t = [ "mousedown.owl", "mousemove.owl", "mouseup.owl" ]), 
            e.ev_types.start = t[0], e.ev_types.move = t[1], e.ev_types.end = t[2];
        },
        disabledEvents: function() {
            this.$elem.on("dragstart.owl", function(e) {
                e.preventDefault();
            }), this.$elem.on("mousedown.disableTextSelect", function(e) {
                return l(e.target).is("input, textarea, select, option");
            });
        },
        gestures: function() {
            var r = this, s = {
                offsetX: 0,
                offsetY: 0,
                baseElWidth: 0,
                relativePos: 0,
                position: null,
                minSwipe: null,
                maxSwipe: null,
                sliding: null,
                dargging: null,
                targetElement: null
            };
            function o(e) {
                if (void 0 !== e.touches) return {
                    x: e.touches[0].pageX,
                    y: e.touches[0].pageY
                };
                if (void 0 === e.touches) {
                    if (void 0 !== e.pageX) return {
                        x: e.pageX,
                        y: e.pageY
                    };
                    if (void 0 === e.pageX) return {
                        x: e.clientX,
                        y: e.clientY
                    };
                }
            }
            function a(e) {
                "on" === e ? (l(c).on(r.ev_types.move, t), l(c).on(r.ev_types.end, n)) : "off" === e && (l(c).off(r.ev_types.move), 
                l(c).off(r.ev_types.end));
            }
            function t(e) {
                var t, n, i = e.originalEvent || e || u.event;
                r.newPosX = o(i).x - s.offsetX, r.newPosY = o(i).y - s.offsetY, r.newRelativeX = r.newPosX - s.relativePos, 
                "function" == typeof r.options.startDragging && !0 !== s.dragging && 0 !== r.newRelativeX && (s.dragging = !0, 
                r.options.startDragging.apply(r, [ r.$elem ])), (8 < r.newRelativeX || r.newRelativeX < -8) && !0 === r.browser.isTouch && (void 0 !== i.preventDefault ? i.preventDefault() : i.returnValue = !1, 
                s.sliding = !0), (10 < r.newPosY || r.newPosY < -10) && !1 === s.sliding && l(c).off("touchmove.owl"), 
                t = function() {
                    return r.newRelativeX / 5;
                }, n = function() {
                    return r.maximumPixels + r.newRelativeX / 5;
                }, r.newPosX = Math.max(Math.min(r.newPosX, t()), n()), !0 === r.browser.support3d ? r.transition3d(r.newPosX) : r.css2move(r.newPosX);
            }
            function n(e) {
                var t, n, i, o = e.originalEvent || e || u.event;
                o.target = o.target || o.srcElement, !(s.dragging = !1) !== r.browser.isTouch && r.$owlWrapper.removeClass("grabbing"), 
                r.newRelativeX < 0 ? r.dragDirection = r.owl.dragDirection = "left" : r.dragDirection = r.owl.dragDirection = "right", 
                0 !== r.newRelativeX && (t = r.getNewPosition(), r.goTo(t, !1, "drag"), s.targetElement === o.target && !0 !== r.browser.isTouch && (l(o.target).on("click.disable", function(e) {
                    e.stopImmediatePropagation(), e.stopPropagation(), e.preventDefault(), l(e.target).off("click.disable");
                }), i = (n = l._data(o.target, "events").click).pop(), n.splice(0, 0, i))), a("off");
            }
            r.isCssFinish = !0, r.$elem.on(r.ev_types.start, ".owl-wrapper", function(e) {
                var t, n = e.originalEvent || e || u.event;
                if (3 === n.which) return !1;
                if (!(r.itemsAmount <= r.options.items)) {
                    if (!1 === r.isCssFinish && !r.options.dragBeforeAnimFinish) return !1;
                    if (!1 === r.isCss3Finish && !r.options.dragBeforeAnimFinish) return !1;
                    !1 !== r.options.autoPlay && u.clearInterval(r.autoPlayInterval), !0 === r.browser.isTouch || r.$owlWrapper.hasClass("grabbing") || r.$owlWrapper.addClass("grabbing"), 
                    r.newPosX = 0, r.newRelativeX = 0, l(this).css(r.removeTransition()), t = l(this).position(), 
                    s.relativePos = t.left, s.offsetX = o(n).x - t.left, s.offsetY = o(n).y - t.top, 
                    a("on"), s.sliding = !1, s.targetElement = n.target || n.srcElement;
                }
            });
        },
        getNewPosition: function() {
            var e = this, t = e.closestItem();
            return t > e.maximumItem ? (e.currentItem = e.maximumItem, t = e.maximumItem) : 0 <= e.newPosX && (t = 0, 
            e.currentItem = 0), t;
        },
        closestItem: function() {
            var n = this, i = !0 === n.options.scrollPerPage ? n.pagesInArray : n.positionsInArray, o = n.newPosX, r = null;
            return l.each(i, function(e, t) {
                o - n.itemWidth / 20 > i[e + 1] && o - n.itemWidth / 20 < t && "left" === n.moveDirection() ? (r = t, 
                !0 === n.options.scrollPerPage ? n.currentItem = l.inArray(r, n.positionsInArray) : n.currentItem = e) : o + n.itemWidth / 20 < t && o + n.itemWidth / 20 > (i[e + 1] || i[e] - n.itemWidth) && "right" === n.moveDirection() && (!0 === n.options.scrollPerPage ? (r = i[e + 1] || i[i.length - 1], 
                n.currentItem = l.inArray(r, n.positionsInArray)) : (r = i[e + 1], n.currentItem = e + 1));
            }), n.currentItem;
        },
        moveDirection: function() {
            var e;
            return this.newRelativeX < 0 ? (e = "right", this.playDirection = "next") : (e = "left", 
            this.playDirection = "prev"), e;
        },
        customEvents: function() {
            var n = this;
            n.$elem.on("owl.next", function() {
                n.next();
            }), n.$elem.on("owl.prev", function() {
                n.prev();
            }), n.$elem.on("owl.play", function(e, t) {
                n.options.autoPlay = t, n.play(), n.hoverStatus = "play";
            }), n.$elem.on("owl.stop", function() {
                n.stop(), n.hoverStatus = "stop";
            }), n.$elem.on("owl.goTo", function(e, t) {
                n.goTo(t);
            }), n.$elem.on("owl.jumpTo", function(e, t) {
                n.jumpTo(t);
            });
        },
        stopOnHover: function() {
            var e = this;
            !0 === e.options.stopOnHover && !0 !== e.browser.isTouch && !1 !== e.options.autoPlay && (e.$elem.on("mouseover", function() {
                e.stop();
            }), e.$elem.on("mouseout", function() {
                "stop" !== e.hoverStatus && e.play();
            }));
        },
        lazyLoad: function() {
            var e, t, n, i, o = this;
            if (!1 === o.options.lazyLoad) return !1;
            for (e = 0; e < o.itemsAmount; e += 1) "loaded" !== (t = l(o.$owlItems[e])).data("owl-loaded") && (n = t.data("owl-item"), 
            "string" == typeof (i = t.find(".lazyOwl")).data("src") ? (void 0 === t.data("owl-loaded") && (i.hide(), 
            t.addClass("loading").data("owl-loaded", "checked")), (!0 !== o.options.lazyFollow || n >= o.currentItem) && n < o.currentItem + o.options.items && i.length && o.lazyPreload(t, i)) : t.data("owl-loaded", "loaded"));
        },
        lazyPreload: function(e, t) {
            var n, i = this, o = 0;
            function r() {
                e.data("owl-loaded", "loaded").removeClass("loading"), t.removeAttr("data-src"), 
                "fade" === i.options.lazyEffect ? t.fadeIn(400) : t.show(), "function" == typeof i.options.afterLazyLoad && i.options.afterLazyLoad.apply(this, [ i.$elem ]);
            }
            "DIV" === t.prop("tagName") ? (t.css("background-image", "url(" + t.data("src") + ")"), 
            n = !0) : t[0].src = t.data("src"), function e() {
                o += 1, i.completeImg(t.get(0)) || !0 === n ? r() : o <= 100 ? u.setTimeout(e, 100) : r();
            }();
        },
        autoHeight: function() {
            var t, n = this, i = l(n.$owlItems[n.currentItem]).find("img");
            function o() {
                var e = l(n.$owlItems[n.currentItem]).height();
                n.wrapperOuter.css("height", e + "px"), n.wrapperOuter.hasClass("autoHeight") || u.setTimeout(function() {
                    n.wrapperOuter.addClass("autoHeight");
                }, 0);
            }
            void 0 !== i.get(0) ? (t = 0, function e() {
                t += 1, n.completeImg(i.get(0)) ? o() : t <= 100 ? u.setTimeout(e, 100) : n.wrapperOuter.css("height", "");
            }()) : o();
        },
        completeImg: function(e) {
            return !!e.complete && ("undefined" === typeof e.naturalWidth || 0 !== e.naturalWidth);
        },
        onVisibleItems: function() {
            var e, t = this;
            for (!0 === t.options.addClassActive && t.$owlItems.removeClass("active"), t.visibleItems = [], 
            e = t.currentItem; e < t.currentItem + t.options.items; e += 1) t.visibleItems.push(e), 
            !0 === t.options.addClassActive && l(t.$owlItems[e]).addClass("active");
            t.owl.visibleItems = t.visibleItems;
        },
        transitionTypes: function(e) {
            this.outClass = "owl-" + e + "-out", this.inClass = "owl-" + e + "-in";
        },
        singleItemTransition: function() {
            var e, t = this, n = t.outClass, i = t.inClass, o = t.$owlItems.eq(t.currentItem), r = t.$owlItems.eq(t.prevItem), s = Math.abs(t.positionsInArray[t.currentItem]) + t.positionsInArray[t.prevItem], a = Math.abs(t.positionsInArray[t.currentItem]) + t.itemWidth / 2, l = "webkitAnimationEnd oAnimationEnd MSAnimationEnd animationend";
            t.isTransition = !0, t.$owlWrapper.addClass("owl-origin").css({
                "-webkit-transform-origin": a + "px",
                "-moz-perspective-origin": a + "px",
                "perspective-origin": a + "px"
            }), r.css((e = s, {
                position: "relative",
                left: e + "px"
            })).addClass(n).on(l, function() {
                t.endPrev = !0, r.off(l), t.clearTransStyle(r, n);
            }), o.addClass(i).on(l, function() {
                t.endCurrent = !0, o.off(l), t.clearTransStyle(o, i);
            });
        },
        clearTransStyle: function(e, t) {
            var n = this;
            e.css({
                position: "",
                left: ""
            }).removeClass(t), n.endPrev && n.endCurrent && (n.$owlWrapper.removeClass("owl-origin"), 
            n.endPrev = !1, n.endCurrent = !1, n.isTransition = !1);
        },
        owlStatus: function() {
            var e = this;
            e.owl = {
                userOptions: e.userOptions,
                baseElement: e.$elem,
                userItems: e.$userItems,
                owlItems: e.$owlItems,
                currentItem: e.currentItem,
                prevItem: e.prevItem,
                visibleItems: e.visibleItems,
                isTouch: e.browser.isTouch,
                browser: e.browser,
                dragDirection: e.dragDirection
            };
        },
        clearEvents: function() {
            this.$elem.off(".owl owl mousedown.disableTextSelect"), l(c).off(".owl owl"), l(u).off("resize", this.resizer);
        },
        unWrap: function() {
            var e = this;
            0 !== e.$elem.children().length && (e.$owlWrapper.unwrap(), e.$userItems.unwrap().unwrap(), 
            e.owlControls && e.owlControls.remove()), e.clearEvents(), e.$elem.attr("style", e.$elem.data("owl-originalStyles") || "").attr("class", e.$elem.data("owl-originalClasses"));
        },
        destroy: function() {
            this.stop(), u.clearInterval(this.checkVisible), this.unWrap(), this.$elem.removeData();
        },
        reinit: function(e) {
            var t = l.extend({}, this.userOptions, e);
            this.unWrap(), this.init(t, this.$elem);
        },
        addItem: function(e, t) {
            var n, i = this;
            return !!e && (0 === i.$elem.children().length ? (i.$elem.append(e), i.setVars(), 
            !1) : (i.unWrap(), (n = void 0 === t || -1 === t ? -1 : t) >= i.$userItems.length || -1 === n ? i.$userItems.eq(-1).after(e) : i.$userItems.eq(n).before(e), 
            void i.setVars()));
        },
        removeItem: function(e) {
            var t;
            if (0 === this.$elem.children().length) return !1;
            t = void 0 === e || -1 === e ? -1 : e, this.unWrap(), this.$userItems.eq(t).remove(), 
            this.setVars();
        }
    };
    l.fn.owlCarousel = function(t) {
        return this.each(function() {
            if (!0 === l(this).data("owl-init")) return !1;
            l(this).data("owl-init", !0);
            var e = Object.create(n);
            e.init(t, this), l.data(this, "owlCarousel", e);
        });
    }, l.fn.owlCarousel.options = {
        items: 5,
        itemsCustom: !1,
        itemsDesktop: [ 1199, 4 ],
        itemsDesktopSmall: [ 979, 3 ],
        itemsTablet: [ 768, 2 ],
        itemsTabletSmall: !1,
        itemsMobile: [ 479, 1 ],
        singleItem: !1,
        itemsScaleUp: !1,
        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1e3,
        autoPlay: !1,
        stopOnHover: !1,
        navigation: !1,
        navigationText: [ "prev", "next" ],
        rewindNav: !0,
        scrollPerPage: !1,
        pagination: !0,
        paginationNumbers: !1,
        responsive: !0,
        responsiveRefreshRate: 200,
        responsiveBaseWidth: u,
        baseClass: "owl-carousel",
        theme: "owl-theme",
        lazyLoad: !1,
        lazyFollow: !0,
        lazyEffect: "fade",
        autoHeight: !1,
        jsonPath: !1,
        jsonSuccess: !1,
        dragBeforeAnimFinish: !0,
        mouseDrag: !0,
        touchDrag: !0,
        addClassActive: !1,
        transitionStyle: !1,
        beforeUpdate: !1,
        afterUpdate: !1,
        beforeInit: !1,
        afterInit: !1,
        beforeMove: !1,
        afterMove: !1,
        afterAction: !1,
        startDragging: !1,
        afterLazyLoad: !1
    };
}(jQuery, window, document);