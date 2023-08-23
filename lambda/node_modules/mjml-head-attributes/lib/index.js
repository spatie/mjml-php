"use strict";

var _interopRequireDefault = require("@babel/runtime/helpers/interopRequireDefault").default;

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = void 0;

var _classCallCheck2 = _interopRequireDefault(require("@babel/runtime/helpers/classCallCheck"));

var _createClass2 = _interopRequireDefault(require("@babel/runtime/helpers/createClass"));

var _inherits2 = _interopRequireDefault(require("@babel/runtime/helpers/inherits"));

var _createSuper2 = _interopRequireDefault(require("@babel/runtime/helpers/createSuper"));

var _defineProperty2 = _interopRequireDefault(require("@babel/runtime/helpers/defineProperty"));

var _reduce2 = _interopRequireDefault(require("lodash/reduce"));

var _omit2 = _interopRequireDefault(require("lodash/omit"));

var _forEach2 = _interopRequireDefault(require("lodash/forEach"));

var _mjmlCore = require("mjml-core");

let MjAttributes = /*#__PURE__*/function (_HeadComponent) {
  (0, _inherits2.default)(MjAttributes, _HeadComponent);

  var _super = (0, _createSuper2.default)(MjAttributes);

  function MjAttributes() {
    (0, _classCallCheck2.default)(this, MjAttributes);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjAttributes, [{
    key: "handler",
    value: function handler() {
      const {
        add
      } = this.context;
      const {
        children
      } = this.props;
      (0, _forEach2.default)(children, child => {
        const {
          tagName,
          attributes,
          children
        } = child;

        if (tagName === 'mj-class') {
          add('classes', attributes.name, (0, _omit2.default)(attributes, ['name']));
          add('classesDefault', attributes.name, (0, _reduce2.default)(children, (acc, {
            tagName,
            attributes
          }) => ({ ...acc,
            [tagName]: attributes
          }), {}));
        } else {
          add('defaultAttributes', tagName, attributes);
        }
      });
    }
  }]);
  return MjAttributes;
}(_mjmlCore.HeadComponent);

exports.default = MjAttributes;
(0, _defineProperty2.default)(MjAttributes, "componentName", 'mj-attributes');
module.exports = exports.default;