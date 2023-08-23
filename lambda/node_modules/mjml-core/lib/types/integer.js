"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = exports.matcher = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _type = _interopRequireDefault(require("./type"));

const matcher = /^integer/gim;
exports.matcher = matcher;

var _default = () => /*#__PURE__*/function (_Type) {
  (0, _inherits2.default)(NInteger, _Type);

  var _super = (0, _createSuper2.default)(NInteger);

  function NInteger(value) {
    var _this;

    (0, _classCallCheck2.default)(this, NInteger);
    _this = _super.call(this, value);
    _this.matchers = [/\d+/];
    return _this;
  }

  return NInteger;
}(_type.default);

exports.default = _default;