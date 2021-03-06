/**
 * State-based routing for AngularJS
 * @version v0.2.8
 * @link http://angular-ui.github.com/
 * @license MIT License, http://www.opensource.org/licenses/MIT
 */
"undefined" != typeof module && "undefined" != typeof exports && module.exports === exports && (module.exports = "ui.router"), function (a, b, c) {
    "use strict";
    function d(a, b) {
        return H(new (H(function () {
        }, {prototype: a})), b)
    }
    function e(a) {
        return G(arguments, function (b) {
            b !== a && G(b, function (b, c) {
                a.hasOwnProperty(c) || (a[c] = b)
            })
        }), a
    }
    function f(a, b) {
        var c = [];
        for (var d in a.path) {
            if (a.path[d] !== b.path[d])
                break;
            c.push(a.path[d])
        }
        return c
    }
    function g(a, b) {
        if (Array.prototype.indexOf)
            return a.indexOf(b, Number(arguments[2]) || 0);
        var c = a.length >>> 0, d = Number(arguments[2]) || 0;
        for (d = 0 > d?Math.ceil(d):Math.floor(d), 0 > d && (d += c); c > d; d++)
            if (d in a && a[d] === b)
                return d;
        return-1
    }
    function h(a, b, c, d) {
        var e, h = f(c, d), i = {}, j = [];
        for (var k in h)
            if (h[k].params && h[k].params.length) {
                e = h[k].params;
                for (var l in e)
                    g(j, e[l]) >= 0 || (j.push(e[l]), i[e[l]] = a[e[l]])
            }
        return H({}, i, b)
    }
    function i(a, b) {
        var c = {};
        return G(a, function (a) {
            var d = b[a];
            c[a] = null != d ? String(d) : null
        }), c
    }
    function j(a, b, c) {
        if (!c) {
            c = [];
            for (var d in a)
                c.push(d)
        }
        for (var e = 0; e < c.length; e++) {
            var f = c[e];
            if (a[f] != b[f])
                return!1
        }
        return!0
    }
    function k(a, b) {
        var c = {};
        return G(a, function (a) {
            c[a] = b[a]
        }), c
    }
    function l(a, b) {
        var d = 1, f = 2, g = {}, h = [], i = g, j = H(a.when(g), {$$promises: g, $$values: g});
        this.study = function (g) {
            function k(a, c) {
                if (o[c] !== f) {
                    if (n.push(c), o[c] === d)
                        throw n.splice(0, n.indexOf(c)), new Error("Cyclic dependency: " + n.join(" -> "));
                    if (o[c] = d, D(a))
                        m.push(c, [function () {
                                return b.get(a)
                            }], h);
                    else {
                        var e = b.annotate(a);
                        G(e, function (a) {
                            a !== c && g.hasOwnProperty(a) && k(g[a], a)
                        }), m.push(c, a, e)
                    }
                    n.pop(), o[c] = f
                }
            }
            function l(a) {
                return E(a) && a.then && a.$$promises
            }
            if (!E(g))
                throw new Error("'invocables' must be an object");
            var m = [], n = [], o = {};
            return G(g, k), g = n = o = null, function (d, f, g) {
                function h() {
                    --s || (t || e(r, f.$$values), p.$$values = r, p.$$promises = !0, o.resolve(r))
                }
                function k(a) {
                    p.$$failure = a, o.reject(a)
                }
                function n(c, e, f) {
                    function i(a) {
                        l.reject(a), k(a)
                    }
                    function j() {
                        if (!B(p.$$failure))
                            try {
                                l.resolve(b.invoke(e, g, r)), l.promise.then(function (a) {
                                    r[c] = a, h()
                                }, i)
                            } catch (a) {
                                i(a)
                            }
                    }
                    var l = a.defer(), m = 0;
                    G(f, function (a) {
                        q.hasOwnProperty(a) && !d.hasOwnProperty(a) && (m++, q[a].then(function (b) {
                            r[a] = b, --m || j()
                        }, i))
                    }), m || j(), q[c] = l.promise
                }
                if (l(d) && g === c && (g = f, f = d, d = null), d) {
                    if (!E(d))
                        throw new Error("'locals' must be an object")
                } else
                    d = i;
                if (f) {
                    if (!l(f))
                        throw new Error("'parent' must be a promise returned by $resolve.resolve()")
                } else
                    f = j;
                var o = a.defer(), p = o.promise, q = p.$$promises = {}, r = H({}, d), s = 1 + m.length / 3, t = !1;
                if (B(f.$$failure))
                    return k(f.$$failure), p;
                f.$$values ? (t = e(r, f.$$values), h()) : (H(q, f.$$promises), f.then(h, k));
                for (var u = 0, v = m.length; v > u; u += 3)
                    d.hasOwnProperty(m[u]) ? h() : n(m[u], m[u + 1], m[u + 2]);
                return p
            }
        }, this.resolve = function (a, b, c, d) {
            return this.study(a)(b, c, d)
        }
    }
    function m(a, b, c) {
        this.fromConfig = function (a, b, c) {
            return B(a.template) ? this.fromString(a.template, b) : B(a.templateUrl) ? this.fromUrl(a.templateUrl, b) : B(a.templateProvider) ? this.fromProvider(a.templateProvider, b, c) : null
        }, this.fromString = function (a, b) {
            return C(a) ? a(b) : a
        }, this.fromUrl = function (c, d) {
            return C(c) && (c = c(d)), null == c ? null : a.get(c, {cache: b}).then(function (a) {
                return a.data
            })
        }, this.fromProvider = function (a, b, d) {
            return c.invoke(a, null, d || {params: b})
        }
    }
    function n(a) {
        function b(b) {
            if (!/^\w+(-+\w+)*$/.test(b))
                throw new Error("Invalid parameter name '" + b + "' in pattern '" + a + "'");
            if (f[b])
                throw new Error("Duplicate parameter name '" + b + "' in pattern '" + a + "'");
            f[b] = !0, j.push(b)
        }
        function c(a) {
            return a.replace(/[\\\[\]\^$*+?.()|{}]/g, "\\$&")
        }
        var d, e = /([:*])(\w+)|\{(\w+)(?:\:((?:[^{}\\]+|\\.|\{(?:[^{}\\]+|\\.)*\})+))?\}/g, f = {}, g = "^", h = 0, i = this.segments = [], j = this.params = [];
        this.source = a;
        for (var k, l, m; (d = e.exec(a)) && (k = d[2] || d[3], l = d[4] || ("*" == d[1]?".*":"[^/]*"), m = a.substring(h, d.index), !(m.indexOf("?") >= 0)); )
            g += c(m) + "(" + l + ")", b(k), i.push(m), h = e.lastIndex;
        m = a.substring(h);
        var n = m.indexOf("?");
        if (n >= 0) {
            var o = this.sourceSearch = m.substring(n);
            m = m.substring(0, n), this.sourcePath = a.substring(0, h + n), G(o.substring(1).split(/[&?]/), b)
        } else
            this.sourcePath = a, this.sourceSearch = "";
        g += c(m) + "$", i.push(m), this.regexp = new RegExp(g), this.prefix = i[0]
    }
    function o() {
        this.compile = function (a) {
            return new n(a)
        }, this.isMatcher = function (a) {
            return E(a) && C(a.exec) && C(a.format) && C(a.concat)
        }, this.$get = function () {
            return this
        }
    }
    function p(a) {
        function b(a) {
            var b = /^\^((?:\\[^a-zA-Z0-9]|[^\\\[\]\^$*+?.()|{}]+)*)/.exec(a.source);
            return null != b ? b[1].replace(/\\(.)/g, "$1") : ""
        }
        function c(a, b) {
            return a.replace(/\$(\$|\d{1,2})/, function (a, c) {
                return b["$" === c ? 0 : Number(c)]
            })
        }
        function d(a, b, c) {
            if (!c)
                return!1;
            var d = a.invoke(b, b, {$match: c});
            return B(d) ? d : !0
        }
        var e = [], f = null;
        this.rule = function (a) {
            if (!C(a))
                throw new Error("'rule' must be a function");
            return e.push(a), this
        }, this.otherwise = function (a) {
            if (D(a)) {
                var b = a;
                a = function () {
                    return b
                }
            } else if (!C(a))
                throw new Error("'rule' must be a function");
            return f = a, this
        }, this.when = function (e, f) {
            var g, h = D(f);
            if (D(e) && (e = a.compile(e)), !h && !C(f) && !F(f))
                throw new Error("invalid 'handler' in when()");
            var i = {matcher: function (b, c) {
                    return h && (g = a.compile(c), c = ["$match", function (a) {
                            return g.format(a)
                        }]), H(function (a, e) {
                        return d(a, c, b.exec(e.path(), e.search()))
                    }, {prefix: D(b.prefix) ? b.prefix : ""})
                }, regex: function (a, e) {
                    if (a.global || a.sticky)
                        throw new Error("when() RegExp must not be global or sticky");
                    return h && (g = e, e = ["$match", function (a) {
                            return c(g, a)
                        }]), H(function (b, c) {
                        return d(b, e, a.exec(c.path()))
                    }, {prefix: b(a)})
                }}, j = {matcher: a.isMatcher(e), regex: e instanceof RegExp};
            for (var k in j)
                if (j[k])
                    return this.rule(i[k](e, f));
            throw new Error("invalid 'what' in when()")
        }, this.$get = ["$location", "$rootScope", "$injector", function (a, b, c) {
                function d(b) {
                    function d(b) {
                        var d = b(c, a);
                        return d ? (D(d) && a.replace().url(d), !0) : !1
                    }
                    if (!b || !b.defaultPrevented) {
                        var g, h = e.length;
                        for (g = 0; h > g; g++)
                            if (d(e[g]))
                                return;
                        f && d(f)
                    }
                }
                return b.$on("$locationChangeSuccess", d), {sync: function () {
                        d()
                    }}
            }]
    }
    function q(a, e, f) {
        function g(a) {
            return 0 === a.indexOf(".") || 0 === a.indexOf("^")
        }
        function l(a, b) {
            var d = D(a), e = d ? a : a.name, f = g(e);
            if (f) {
                if (!b)
                    throw new Error("No reference point given for path '" + e + "'");
                for (var h = e.split("."), i = 0, j = h.length, k = b; j > i; i++)
                    if ("" !== h[i] || 0 !== i) {
                        if ("^" !== h[i])
                            break;
                        if (!k.parent)
                            throw new Error("Path '" + e + "' not valid for state '" + b.name + "'");
                        k = k.parent
                    } else
                        k = b;
                h = h.slice(i).join("."), e = k.name + (k.name && h ? "." : "") + h
            }
            var l = u[e];
            return!l || !d && (d || l !== a && l.self !== a) ? c : l
        }
        function m(a, b) {
            v[a] || (v[a] = []), v[a].push(b)
        }
        function n(b) {
            b = d(b, {self: b, resolve: b.resolve || {}, toString: function () {
                    return this.name
                }});
            var c = b.name;
            if (!D(c) || c.indexOf("@") >= 0)
                throw new Error("State must have a valid name");
            if (u.hasOwnProperty(c))
                throw new Error("State '" + c + "'' is already defined");
            var e = -1 !== c.indexOf(".") ? c.substring(0, c.lastIndexOf(".")) : D(b.parent) ? b.parent : "";
            if (e && !u[e])
                return m(e, b.self);
            for (var f in x)
                C(x[f]) && (b[f] = x[f](b, x.$delegates[f]));
            if (u[c] = b, !b[w] && b.url && a.when(b.url, ["$match", "$stateParams", function (a, c) {
                    t.$current.navigable == b && j(a, c) || t.transitionTo(b, a, {location: !1})
                }]), v[c])
                for (var g = 0; g < v[c].length; g++)
                    n(v[c][g]);
            return b
        }
        function o(a, b) {
            return D(a) && !B(b) ? x[a] : C(b) && D(a) ? (x[a] && !x.$delegates[a] && (x.$delegates[a] = x[a]), x[a] = b, this) : this
        }
        function p(a, b) {
            return E(a) ? b = a : b.name = a, n(b), this
        }
        function q(a, e, g, m, n, o, p) {
            function q() {
                p.url() !== D && (p.url(D), p.replace())
            }
            function v(a, c, d, f, h) {
                var i = d ? c : k(a.params, c), j = {$stateParams: i};
                h.resolve = n.resolve(a.resolve, j, h.resolve, a);
                var l = [h.resolve.then(function (a) {
                        h.globals = a
                    })];
                return f && l.push(f), G(a.views, function (c, d) {
                    var e = c.resolve && c.resolve !== a.resolve ? c.resolve : {};
                    e.$template = [function () {
                            return g.load(d, {view: c, locals: j, params: i, notify: !1}) || ""
                        }], l.push(n.resolve(e, j, h.resolve, a).then(function (f) {
                        if (C(c.controllerProvider) || F(c.controllerProvider)) {
                            var g = b.extend({}, e, j);
                            f.$$controller = m.invoke(c.controllerProvider, null, g)
                        } else
                            f.$$controller = c.controller;
                        f.$$state = a, h[d] = f
                    }))
                }), e.all(l).then(function () {
                    return h
                })
            }
            var x = e.reject(new Error("transition superseded")), y = e.reject(new Error("transition prevented")), z = e.reject(new Error("transition aborted")), A = e.reject(new Error("transition failed")), D = p.url();
            return s.locals = {resolve: null, globals: {$stateParams: {}}}, t = {params: {}, current: s.self, $current: s, transition: null}, t.reload = function () {
                t.transitionTo(t.current, o, {reload: !0, inherit: !1, notify: !1})
            }, t.go = function (a, b, c) {
                return this.transitionTo(a, b, H({inherit: !0, relative: t.$current}, c))
            }, t.transitionTo = function (b, c, f) {
                c = c || {}, f = H({location: !0, inherit: !1, relative: null, notify: !0, reload: !1, $retry: !1}, f || {});
                var g, k = t.$current, n = t.params, u = k.path, C = l(b, f.relative);
                if (!B(C)) {
                    var E = {to: b, toParams: c, options: f};
                    if (g = a.$broadcast("$stateNotFound", E, k.self, n), g.defaultPrevented)
                        return q(), z;
                    if (g.retry) {
                        if (f.$retry)
                            return q(), A;
                        var F = t.transition = e.when(g.retry);
                        return F.then(function () {
                            return F !== t.transition ? x : (E.options.$retry = !0, t.transitionTo(E.to, E.toParams, E.options))
                        }, function () {
                            return z
                        }), q(), F
                    }
                    if (b = E.to, c = E.toParams, f = E.options, C = l(b, f.relative), !B(C)) {
                        if (f.relative)
                            throw new Error("Could not resolve '" + b + "' from state '" + f.relative + "'");
                        throw new Error("No such state '" + b + "'")
                    }
                }
                if (C[w])
                    throw new Error("Cannot transition to abstract state '" + b + "'");
                f.inherit && (c = h(o, c || {}, t.$current, C)), b = C;
                var G, J, K = b.path, L = s.locals, M = [];
                for (G = 0, J = K[G]; J && J === u[G] && j(c, n, J.ownParams) && !f.reload; G++, J = K[G])
                    L = M[G] = J.locals;
                if (r(b, k, L, f))
                    return b.self.reloadOnSearch !== !1 && q(), t.transition = null, e.when(t.current);
                if (c = i(b.params, c || {}), f.notify && (g = a.$broadcast("$stateChangeStart", b.self, c, k.self, n), g.defaultPrevented))
                    return q(), y;
                for (var N = e.when(L), O = G; O < K.length; O++, J = K[O])
                    L = M[O] = d(L), N = v(J, c, J === b, N, L);
                var P = t.transition = N.then(function () {
                    var d, e, g;
                    if (t.transition !== P)
                        return x;
                    for (d = u.length - 1; d >= G; d--)
                        g = u[d], g.self.onExit && m.invoke(g.self.onExit, g.self, g.locals.globals), g.locals = null;
                    for (d = G; d < K.length; d++)
                        e = K[d], e.locals = M[d], e.self.onEnter && m.invoke(e.self.onEnter, e.self, e.locals.globals);
                    if (t.transition !== P)
                        return x;
                    t.$current = b, t.current = b.self, t.params = c, I(t.params, o), t.transition = null;
                    var h = b.navigable;
                    return f.location && h && (p.url(h.url.format(h.locals.globals.$stateParams)), "replace" === f.location && p.replace()), f.notify && a.$broadcast("$stateChangeSuccess", b.self, c, k.self, n), D = p.url(), t.current
                }, function (d) {
                    return t.transition !== P ? x : (t.transition = null, a.$broadcast("$stateChangeError", b.self, c, k.self, n, d), q(), e.reject(d))
                });
                return P
            }, t.is = function (a, d) {
                var e = l(a);
                return B(e) ? t.$current !== e ? !1 : B(d) && null !== d ? b.equals(o, d) : !0 : c
            }, t.includes = function (a, d) {
                var e = l(a);
                if (!B(e))
                    return c;
                if (!B(t.$current.includes[e.name]))
                    return!1;
                var f = !0;
                return b.forEach(d, function (a, b) {
                    B(o[b]) && o[b] === a || (f = !1)
                }), f
            }, t.href = function (a, b, c) {
                c = H({lossy: !0, inherit: !1, absolute: !1, relative: t.$current}, c || {});
                var d = l(a, c.relative);
                if (!B(d))
                    return null;
                b = h(o, b || {}, t.$current, d);
                var e = d && c.lossy ? d.navigable : d, g = e && e.url ? e.url.format(i(d.params, b || {})) : null;
                return!f.html5Mode() && g && (g = "#" + f.hashPrefix() + g), c.absolute && g && (g = p.protocol() + "://" + p.host() + (80 == p.port() || 443 == p.port() ? "" : ":" + p.port()) + (!f.html5Mode() && g ? "/" : "") + g), g
            }, t.get = function (a, b) {
                if (!B(a)) {
                    var c = [];
                    return G(u, function (a) {
                        c.push(a.self)
                    }), c
                }
                var d = l(a, b);
                return d && d.self ? d.self : null
            }, t
        }
        function r(a, b, c, d) {
            return a !== b || (c !== b.locals || d.reload) && a.self.reloadOnSearch !== !1 ? void 0 : !0
        }
        var s, t, u = {}, v = {}, w = "abstract", x = {parent: function (a) {
                if (B(a.parent) && a.parent)
                    return l(a.parent);
                var b = /^(.+)\.[^.]+$/.exec(a.name);
                return b ? l(b[1]) : s
            }, data: function (a) {
                return a.parent && a.parent.data && (a.data = a.self.data = H({}, a.parent.data, a.data)), a.data
            }, url: function (a) {
                var b = a.url;
                if (D(b))
                    return"^" == b.charAt(0) ? e.compile(b.substring(1)) : (a.parent.navigable || s).url.concat(b);
                if (e.isMatcher(b) || null == b)
                    return b;
                throw new Error("Invalid url '" + b + "' in state '" + a + "'")
            }, navigable: function (a) {
                return a.url ? a : a.parent ? a.parent.navigable : null
            }, params: function (a) {
                if (!a.params)
                    return a.url ? a.url.parameters() : a.parent.params;
                if (!F(a.params))
                    throw new Error("Invalid params in state '" + a + "'");
                if (a.url)
                    throw new Error("Both params and url specicified in state '" + a + "'");
                return a.params
            }, views: function (a) {
                var b = {};
                return G(B(a.views) ? a.views : {"": a}, function (c, d) {
                    d.indexOf("@") < 0 && (d += "@" + a.parent.name), b[d] = c
                }), b
            }, ownParams: function (a) {
                if (!a.parent)
                    return a.params;
                var b = {};
                G(a.params, function (a) {
                    b[a] = !0
                }), G(a.parent.params, function (c) {
                    if (!b[c])
                        throw new Error("Missing required parameter '" + c + "' in state '" + a.name + "'");
                    b[c] = !1
                });
                var c = [];
                return G(b, function (a, b) {
                    a && c.push(b)
                }), c
            }, path: function (a) {
                return a.parent ? a.parent.path.concat(a) : []
            }, includes: function (a) {
                var b = a.parent ? H({}, a.parent.includes) : {};
                return b[a.name] = !0, b
            }, $delegates: {}};
        s = n({name: "", url: "^", views: null, "abstract": !0}), s.navigable = null, this.decorator = o, this.state = p, this.$get = q, q.$inject = ["$rootScope", "$q", "$view", "$injector", "$resolve", "$stateParams", "$location", "$urlRouter"]
    }
    function r() {
        function a(a, b) {
            return{load: function (c, d) {
                    var e, f = {template: null, controller: null, view: null, locals: null, notify: !0, async: !0, params: {}};
                    return d = H(f, d), d.view && (e = b.fromConfig(d.view, d.params, d.locals)), e && d.notify && a.$broadcast("$viewContentLoading", d), e
                }}
        }
        this.$get = a, a.$inject = ["$rootScope", "$templateFactory"]
    }
    function s() {
        var a = !1;
        this.useAnchorScroll = function () {
            a = !0
        }, this.$get = ["$anchorScroll", "$timeout", function (b, c) {
                return a ? b : function (a) {
                    c(function () {
                        a[0].scrollIntoView()
                    }, 0, !1)
                }
            }]
    }
    function t(a, c, d, e, f, g) {
        function h() {
            return e.has ? function (a) {
                return e.has(a) ? e.get(a) : null
            } : function (a) {
                try {
                    return e.get(a)
                } catch (b) {
                    return null
                }
            }
        }
        function i(a, b, c) {
            var d = function () {
                return{leave: function (a) {
                        a.remove()
                    }, enter: function (a, b, c) {
                        c.after(a)
                    }}
            };
            if (m)
                return function (a) {
                    return a ? {enter: function (a, b, c) {
                            m.enter(a, null, c)
                        }, leave: function (a) {
                            m.leave(a, function () {
                                a.remove()
                            })
                        }} : d()
                };
            if (l) {
                var e = l && l(c, b);
                return function (a) {
                    return a ? {enter: function (a, b) {
                            e.enter(a, b)
                        }, leave: function (a) {
                            e.leave(a.contents(), a)
                        }} : d()
                }
            }
            return d
        }
        var j = !1, k = h(), l = k("$animator"), m = k("$animate"), n = {restrict: "ECA", compile: function (e, h) {
                var k = e.html(), l = !0, m = b.element(g[0].createComment(" ui-view-anchor ")), o = e.parent();
                return e.prepend(m), function (g) {
                    function p() {
                        s && (y(!0).leave(s), s = null), r && (r.$destroy(), r = null)
                    }
                    function q(h) {
                        var i = a.$current && a.$current.locals[v];
                        if (l && (l = !1, e.replaceWith(m)), !i)
                            return p(), s = e.clone(), s.html(k), y(h).enter(s, o, m), r = g.$new(), c(s.contents())(r), void 0;
                        if (i !== t) {
                            p(), s = e.clone(), s.html(i.$template ? i.$template : k), y(!0).enter(s, o, m), s.data("$uiView", z), t = i, z.state = i.$$state;
                            var j = c(s.contents());
                            if (r = g.$new(), i.$$controller) {
                                i.$scope = r;
                                var n = d(i.$$controller, i);
                                s.children().data("$ngControllerController", n)
                            }
                            j(r), r.$emit("$viewContentLoaded"), w && r.$eval(w), b.isDefined(x) && x && !g.$eval(x) || f(s)
                        }
                    }
                    var r, s, t, u = o.inheritedData("$uiView"), v = h[n.name] || h.name || "", w = h.onload || "", x = h.autoscroll, y = i(e, h, g);
                    v.indexOf("@") < 0 && (v = v + "@" + (u ? u.state.name : ""));
                    var z = {name: v, state: null}, A = function () {
                        if (!j) {
                            j = !0;
                            try {
                                q(!0)
                            } catch (a) {
                                throw j = !1, a
                            }
                            j = !1
                        }
                    };
                    g.$on("$stateChangeSuccess", A), g.$on("$viewContentLoading", A), q(!1)
                }
            }};
        return n
    }
    function u(a) {
        var b = a.replace(/\n/g, " ").match(/^([^(]+?)\s*(\((.*)\))?$/);
        if (!b || 4 !== b.length)
            throw new Error("Invalid state ref '" + a + "'");
        return{state: b[1], paramExpr: b[3] || null}
    }
    function v(a) {
        var b = a.parent().inheritedData("$uiView");
        return b && b.state && b.state.name ? b.state : void 0
    }
    function w(a, b) {
        return{restrict: "A", require: "?^uiSrefActive", link: function (c, d, e, f) {
                var g = u(e.uiSref), h = null, i = v(d) || a.$current, j = "FORM" === d[0].nodeName, k = j ? "action" : "href", l = !0, m = function (b) {
                    if (b && (h = b), l) {
                        var c = a.href(g.state, h, {relative: i});
                        return f && f.$$setStateInfo(g.state, h), c ? (d[0][k] = c, void 0) : (l = !1, !1)
                    }
                };
                g.paramExpr && (c.$watch(g.paramExpr, function (a) {
                    a !== h && m(a)
                }, !0), h = c.$eval(g.paramExpr)), m(), j || d.bind("click", function (c) {
                    var e = c.which || c.button;
                    0 !== e && 1 != e || c.ctrlKey || c.metaKey || c.shiftKey || d.attr("target") || (b(function () {
                        a.go(g.state, h, {relative: i})
                    }), c.preventDefault())
                })
            }}
    }
    function x(a, b, c) {
        return{restrict: "A", controller: ["$scope", "$element", "$attrs", function (d, e, f) {
                    function g() {
                        a.$current.self === i && h() ? e.addClass(l) : e.removeClass(l)
                    }
                    function h() {
                        return!k || j(k, b)
                    }
                    var i, k, l;
                    l = c(f.uiSrefActive || "", !1)(d), this.$$setStateInfo = function (b, c) {
                        i = a.get(b, v(e)), k = c, g()
                    }, d.$on("$stateChangeSuccess", g)
                }]}
    }
    function y(a) {
        return function (b) {
            return a.is(b)
        }
    }
    function z(a) {
        return function (b) {
            return a.includes(b)
        }
    }
    function A(a, b) {
        function e(a) {
            this.locals = a.locals.globals, this.params = this.locals.$stateParams
        }
        function f() {
            this.locals = null, this.params = null
        }
        function g(c, g) {
            if (null != g.redirectTo) {
                var h, j = g.redirectTo;
                if (D(j))
                    h = j;
                else {
                    if (!C(j))
                        throw new Error("Invalid 'redirectTo' in when()");
                    h = function (a, b) {
                        return j(a, b.path(), b.search())
                    }
                }
                b.when(c, h)
            } else
                a.state(d(g, {parent: null, name: "route:" + encodeURIComponent(c), url: c, onEnter: e, onExit: f}));
            return i.push(g), this
        }
        function h(a, b, d) {
            function e(a) {
                return"" !== a.name ? a : c
            }
            var f = {routes: i, params: d, current: c};
            return b.$on("$stateChangeStart", function (a, c, d, f) {
                b.$broadcast("$routeChangeStart", e(c), e(f))
            }), b.$on("$stateChangeSuccess", function (a, c, d, g) {
                f.current = e(c), b.$broadcast("$routeChangeSuccess", e(c), e(g)), I(d, f.params)
            }), b.$on("$stateChangeError", function (a, c, d, f, g, h) {
                b.$broadcast("$routeChangeError", e(c), e(f), h)
            }), f
        }
        var i = [];
        e.$inject = ["$$state"], this.when = g, this.$get = h, h.$inject = ["$state", "$rootScope", "$routeParams"]
    }
    var B = b.isDefined, C = b.isFunction, D = b.isString, E = b.isObject, F = b.isArray, G = b.forEach, H = b.extend, I = b.copy;
    b.module("ui.router.util", ["ng"]), b.module("ui.router.router", ["ui.router.util"]), b.module("ui.router.state", ["ui.router.router", "ui.router.util"]), b.module("ui.router", ["ui.router.state"]), b.module("ui.router.compat", ["ui.router"]), l.$inject = ["$q", "$injector"], b.module("ui.router.util").service("$resolve", l), m.$inject = ["$http", "$templateCache", "$injector"], b.module("ui.router.util").service("$templateFactory", m), n.prototype.concat = function (a) {
        return new n(this.sourcePath + a + this.sourceSearch)
    }, n.prototype.toString = function () {
        return this.source
    }, n.prototype.exec = function (a, b) {
        var c = this.regexp.exec(a);
        if (!c)
            return null;
        var d, e = this.params, f = e.length, g = this.segments.length - 1, h = {};
        if (g !== c.length - 1)
            throw new Error("Unbalanced capture group in route '" + this.source + "'");
        for (d = 0; g > d; d++)
            h[e[d]] = c[d + 1];
        for (; f > d; d++)
            h[e[d]] = b[e[d]];
        return h
    }, n.prototype.parameters = function () {
        return this.params
    }, n.prototype.format = function (a) {
        var b = this.segments, c = this.params;
        if (!a)
            return b.join("");
        var d, e, f, g = b.length - 1, h = c.length, i = b[0];
        for (d = 0; g > d; d++)
            f = a[c[d]], null != f && (i += encodeURIComponent(f)), i += b[d + 1];
        for (; h > d; d++)
            f = a[c[d]], null != f && (i += (e ? "&" : "?") + c[d] + "=" + encodeURIComponent(f), e = !0);
        return i
    }, b.module("ui.router.util").provider("$urlMatcherFactory", o), p.$inject = ["$urlMatcherFactoryProvider"], b.module("ui.router.router").provider("$urlRouter", p), q.$inject = ["$urlRouterProvider", "$urlMatcherFactoryProvider", "$locationProvider"], b.module("ui.router.state").value("$stateParams", {}).provider("$state", q), r.$inject = [], b.module("ui.router.state").provider("$view", r), b.module("ui.router.state").provider("$uiViewScroll", s), t.$inject = ["$state", "$compile", "$controller", "$injector", "$uiViewScroll", "$document"], b.module("ui.router.state").directive("uiView", t), w.$inject = ["$state", "$timeout"], x.$inject = ["$state", "$stateParams", "$interpolate"], b.module("ui.router.state").directive("uiSref", w).directive("uiSrefActive", x), y.$inject = ["$state"], z.$inject = ["$state"], b.module("ui.router.state").filter("isState", y).filter("includedByState", z), A.$inject = ["$stateProvider", "$urlRouterProvider"], b.module("ui.router.compat").provider("$route", A).directive("ngView", t)
}(window, window.angular);