var path = require('path');

exports.hasProcessFlag = function(flag) {
    return process.argv.join('').indexOf(flag) > -1;
};

exports.hasNpmFlag = function(flag) {
    return (process.env.npm_lifecycle_event || '').includes(flag);
};

exports.root = function(args) {
    var _root = path.resolve(__dirname, '..');
    args = Array.prototype.slice.call(arguments, 0);
    return path.join.apply(path, [_root].concat(args));
};

exports.empty = {
    NgProbeToken: {},
    HmrState: function() {},
    _createConditionalRootRenderer: function(rootRenderer, extraTokens, coreTokens) {
        return rootRenderer;
    },
    __platform_browser_private__: {}
};
