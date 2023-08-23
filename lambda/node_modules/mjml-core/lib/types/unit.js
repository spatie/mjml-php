"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = exports.matcher = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _escapeRegExp2 = _interopRequireDefault(require("lodash/escapeRegExp"));

var _type = _interopRequireDefault(require("./type"));

const matcher = /^(unit|unitWithNegative)\(.*\)/gim;
exports.matcher = matcher;

var _default = params => {
  var _class, _temp;

  const allowNeg = params.match(/^unitWithNegative/) ? '-|' : '';
  const units = params.match(/\(([^)]+)\)/)[1].split(',');
  const argsMatch = params.match(/\{([^}]+)\}/);
  const args = argsMatch && argsMatch[1] && argsMatch[1].split(',') || ['1']; // defaults to 1

  const allowAuto = units.includes('auto') ? '|auto' : '';
  const filteredUnits = units.filter(u => u !== 'auto');
  return _temp = _class = /*#__PURE__*/function (_Type) {
    (0, _inherits2.default)(Unit, _Type);

    var _super = (0, _createSuper2.default)(Unit);

    function Unit(value) {
      var _this;

      (0, _classCallCheck2.default)(this, Unit);
      _this = _super.call(this, value);
      _this.matchers = [new RegExp(`^(((${allowNeg}\\d|,|\\.){1,}(${filteredUnits.map(_escapeRegExp2.default).join('|')})|0${allowAuto})( )?){${args.join(',')}}$`)];
      return _this;
    }

    return Unit;
  }(_type.default), (0, _defineProperty2.default)(_class, "errorMessage", `has invalid value: $value for type Unit, only accepts (${units.join(', ')}) units and ${args.join(' to ')} value(s)`), _temp;
};

exports.default = _default;