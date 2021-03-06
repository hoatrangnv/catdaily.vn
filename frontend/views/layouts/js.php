<?php
/**
 * @var $this \yii\web\View
 */
use common\models\SiteParam;
use common\models\UrlParam;
use yii\helpers\Url;
?>
<script>
    !function (paras) {
        [].forEach.call(paras, function (para) {
            var iFrames = para.querySelectorAll('iframe[src^="https://www.youtube.com/embed/"]');
            [].forEach.call(iFrames, function (iFrame) {
                if (!iFrame.getAttribute('width') && !iFrame.getAttribute('height')) {
                    var wrapperInner = element('div', null);
                    var wrapper = element('div', wrapperInner, {class: 'video aspect-ratio __16x9'});
                    iFrame.parentNode.insertBefore(wrapper, iFrame);
                    wrapperInner.appendChild(iFrame);
                }
            });
        });
    }(document.querySelectorAll('.paragraph'));

    if (window.innerWidth > 640) {
        !function (containers) {
            [].forEach.call(containers, function (container) {
                var scrollFixedId = container.getAttribute('data-scroll-fixed-container');
                var scrollFixedElms = container.querySelectorAll('[data-scroll-fixed-in="' + scrollFixedId + '"]:not([data-scroll-fixed]):not([data-scroll-fixed-copy])');
                var startY = container.getAttribute('data-scroll-fixed-start');
                [].forEach.call(scrollFixedElms, function (el) {
                    initScrollFixed(el, container, startY);
                });
            });
        }(document.querySelectorAll('[data-scroll-fixed-container]'));
    }

    /**
     *
     * @param {HTMLElement} el
     * @param {HTMLElement} ctn
     * @param {string} startY
     */
    function initScrollFixed(el, ctn, startY) {
        var copy = el.cloneNode(true);
        copy.style.visibility = 'hidden';
        copy.style.pointerEvents = 'none';

        el.setAttribute('data-scroll-fixed', '');
        copy.setAttribute('data-scroll-fixed-copy', '');

        window.addEventListener('scroll', function () {
            var elRect = el.getBoundingClientRect();
            var copyRect = copy.getBoundingClientRect();
            var ctnRect = ctn.getBoundingClientRect();
            var y0;

            if (startY && isNaN(startY)) {
                var topEl = document.querySelector(startY + ':not([data-scroll-fixed-copy])');
                if (topEl) {
                    y0 = topEl.getBoundingClientRect().bottom;
                } else {
                    y0 = 0;
                }
            } else {
                y0 = Number(startY) || 0;
            }

            if (elRect.top + copyRect.top < y0) {
                // console.log('scroll case 1');
                el.parentNode.insertBefore(copy, el);
                el.style.position = 'fixed';
                el.style.width = copy.offsetWidth + 'px';

                if (ctnRect.top + ctn.offsetHeight > el.offsetHeight + y0) {
                    el.style.top = y0 + 'px';
                } else {
                    el.style.top = (ctnRect.top + ctn.offsetHeight) - el.offsetHeight + 'px';
                }

                el.setAttribute('data-scroll-fixed', 'fixed');
            } else if (elRect.top + copyRect.top > y0 * 2) { // should not use `>=`, when y0 === 0 it will be lag
                // console.log('scroll case 2');
                el.style.top = copy.style.top;
                el.style.position = copy.style.position;
                if (copy.parentNode) {
                    copy.parentNode.removeChild(copy);
                }

                el.setAttribute('data-scroll-fixed', 'released');
            }
        });
    }
</script>

<script>
    // Init sliders
    [].forEach.call(document.querySelectorAll(".slider"), initSlider);

    /**
     *
     * @param {HTMLElement} container
     * @param {HTMLElement} button
     * @param {string} viewId
     * @param {object} jsonParams
     * @param {int} page
     * @param {function|undefined} onSuccess
     * @param {function|undefined} onError
     */
    function loadMoreArticles(container, button, viewId, jsonParams, page, onSuccess, onError) {
        button.disabled = true;
        button.classList.add("loading");

        var xhttp = new XMLHttpRequest();

        xhttp.onload = function () {
            var data = JSON.parse(xhttp.responseText);
            container.innerHTML += data.content;
            if (!data.hasMore) {
                button.parentNode.removeChild(button);
            }
            if ("function" === typeof onSuccess) {
                onSuccess();
            }
        };
        xhttp.onloadend = function () {
            button.disabled = false;
            button.classList.remove("loading");
        };
        xhttp.onerror = function () {
            if ("function" === typeof onError) {
                onError();
            }
        };

        xhttp.open("POST", "<?= Url::to(['article/ajax-get-items'], true) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken
            . '&' . UrlParam::VIEW_ID . '=" + viewId + "'
            . '&' . UrlParam::JSON_PARAMS . '=" + JSON.stringify(jsonParams) + "'
            . '&' . UrlParam::PAGE . '=" + page + "'
            ?>");
    }

    /**
     *
     * @param {int} id
     * @param {string} field
     * @param {int} value
     */
    function updateArticleCounter(id, field, value) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "<?= Url::to(['article/ajax-update-counter']) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken
            . '&' . UrlParam::FIELD . '=" + field + "'
            . '&' . UrlParam::VALUE . '=" + value + "'
            . '&' . UrlParam::ID . '=" + id + "'
        ?>");
    }

    /**
     * Determine the mobile operating system.
     * This function returns one of 'iOS', 'Android', 'Windows Phone', or 'unknown'.
     *
     * @returns {String}
     */
    function getMobileOperatingSystem() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        // Windows Phone must come first because its UA also contains "Android"
        if (/windows phone/i.test(userAgent)) {
            return "Windows Phone";
        }

        if (/android/i.test(userAgent)) {
            return "Android";
        }

        // iOS detection from: http://stackoverflow.com/a/9039885/177710
        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            return "iOS";
        }

        return "unknown";
    }
</script>

<script>
    /**
     *
     * @param {Node} msg_html
     */
    function popup(msg_html) {
        var msg = element(
            "div",
            msg_html,
            {
                style: style({
                    background: "white",
                    padding: msg_html instanceof HTMLElement ? "0" : "1rem",
                    "border-radius": "4px",
                    "line-height": "1.5em",
                    "max-width": Math.min(1000, 0.9 * window.innerWidth) + "px",
                    "max-height": 0.9 * window.innerHeight + "px"
                })
            }
        );

        var closeBtn = element(
            "button",
            "close",
            {
                type: "button",
                style: style({
                    color: "white",
                    position: "absolute",
                    top: 0,
                    right: 0,
                    padding: "0.5em",
                    border: "none",
                    cursor: "pointer",
                    "background-color": "rgba(0, 0, 0, 0.5)"
                })
            }
        );

        var container = element(
            "div",
            [msg, closeBtn],
            {
                style: style({
                    position: "fixed",
                    top: 0,
                    left: 0,
                    bottom: 0,
                    right: 0,
                    display: "flex",
                    "align-items": "center",
                    "justify-content": "center",
                    "z-index": 9999,
                    "background-color": "rgba(0, 0, 0, 0.5)"
                })
            }
        );

        document.addEventListener("click", function (event) {
            if (container.contains(event.target)
                && msg !== event.target
                && !msg.contains(event.target)
                && container.parentNode
            ) {
                container.parentNode.removeChild(container);
            }
        });

        closeBtn.addEventListener("click", function () {
            if (container.parentNode) {
                container.parentNode.removeChild(container);
            }
        });

        document.body.appendChild(container);
    }

    function element(nodeName, content, attributes, eventListeners) {
        var node = document.createElement(nodeName);
        appendChildren(node, content);
        setAttributes(node, attributes);
        addEventListeners(node, eventListeners);
        return node;
    }

    function appendChildren(node, content) {
        var append = function (t) {
            if ("string" == typeof t) {
                node.innerHTML += t;
            } else if (t instanceof HTMLElement) {
                node.appendChild(t);
            }
        };
        if (content instanceof Array) {
            content.forEach(function (item) {
                append(item);
            });
        } else {
            append(content);
        }
    }

    function setAttributes(node, attributes) {
        if (attributes) {
            var attrName;
            for (attrName in attributes) {
                if (attributes.hasOwnProperty(attrName)) {
                    node.setAttribute(attrName, attributes[attrName]);
                }
            }
        }
    }

    function addEventListeners(node, listeners) {
        if (listeners) {
            var eventName;
            for (eventName in listeners) {
                if (listeners.hasOwnProperty(eventName)) {
                    if (listeners[eventName] instanceof Array) {
                        listeners[eventName].forEach(function (listener) {
                            node.addEventListener(eventName, listener)
                        })
                    } else {
                        node.addEventListener(eventName, listeners[eventName]);
                    }
                }
            }
        }
    }

    function style(obj) {
        var result_array = [];
        var attrName;
        for (attrName in obj) {
            if (Object.prototype.hasOwnProperty.call(obj, attrName)) {
                result_array.push(attrName + ":" + obj[attrName]);
            }
        }
        return result_array.join(";");
    }

</script>
