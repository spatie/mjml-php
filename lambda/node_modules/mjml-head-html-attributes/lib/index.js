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

var _get2 = _interopRequireDefault(require("lodash/get"));

var _mjmlCore = require("mjml-core");

let MjHtmlAttributes = /*#__PURE__*/function (_HeadComponent) {
  (0, _inherits2.default)(MjHtmlAttributes, _HeadComponent);

  var _super = (0, _createSuper2.default)(MjHtmlAttributes);

  function MjHtmlAttributes() {
    (0, _classCallCheck2.default)(this, MjHtmlAttributes);
    return _super.apply(this, arguments);
  }

  (0, _createClass2.default)(MjHtmlAttributes, [{
    key: "handler",
    value: function handler() {
      const {
        add
      } = this.context;
      const {
        children
      } = this.props;
      children.filter(c => c.tagName === 'mj-selector').forEach(selector => {
        const {
          attributes,
          children
        } = selector;
        const {
          path
        } = attributes;
        const custom = children.filter(c => c.tagName === 'mj-html-attribute' && !!(0, _get2.default)(c, 'attributes.name')).reduce((acc, c) => ({ ...acc,
          [c.attributes.name]: c.content
        }), {});
        add('htmlAttributes', path, custom);
      });
    }
  }]);
  return MjHtmlAttributes;
}(_mjmlCore.HeadComponent);

exports.default = MjHtmlAttributes;
(0, _defineProperty2.default)(MjHtmlAttributes, "componentName", 'mj-html-attributes');
module.exports = exports.default;