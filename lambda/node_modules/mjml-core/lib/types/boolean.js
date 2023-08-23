"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = exports.matcher = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _type = _interopRequireDefault(require("./type"));

const matcher = /^boolean/gim;
exports.matcher = matcher;

var _default = () => /*#__PURE__*/function (_Type) {
  (0, _inherits2.default)(Boolean, _Type);

  var _super = (0, _createSuper2.default)(Boolean);

  function Boolean(boolean) {
    var _this;

    (0, _classCallCheck2.default)(this, Boolean);
    _this = _super.call(this, boolean);
    _this.matchers = [/^true$/i, /^false$/i];
    return _this;
  }

  (0, _createClass2.default)(Boolean, [{
    key: "isValid",
    value: function isValid() {
      return this.value === true || this.value === false;
    }
  }]);
  return Boolean;
}(_type.default);

exports.default = _default;