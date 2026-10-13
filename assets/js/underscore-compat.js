/**
 * Underscore.js compatibility polyfill.
 *
 * WordPress 7.x ships a modern Underscore/Lodash build that removed
 * _.pluck, _.contains, and _.object.  WordPress core files
 * (mce-view, wp-backbone, media-views) still call them, so we
 * re-add them here.  This file MUST load after underscore.js and
 * before wp-backbone / mce-view.
 */
(function () {
    if (typeof _ === 'undefined') return;

    if (typeof _.pluck !== 'function') {
        _.pluck = function (obj, key) {
            return _.map(obj, _.property(key));
        };
    }

    if (typeof _.contains !== 'function') {
        _.contains = _.includes || function (obj, item) {
            return _.indexOf(obj, item) >= 0;
        };
    }

    if (typeof _.object !== 'function') {
        _.object = function (keys, vals) {
            var result = {};
            for (var i = 0, l = keys.length; i < l; i++) {
                if (vals) {
                    result[keys[i]] = vals[i];
                } else {
                    result[keys[i][0]] = keys[i][1];
                }
            }
            return result;
        };
    }
})();
