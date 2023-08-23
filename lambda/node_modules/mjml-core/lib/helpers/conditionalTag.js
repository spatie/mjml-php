"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = conditionalTag;
exports.msoConditionalTag = msoConditionalTag;
exports.endNegationConditionalTag = exports.startMsoNegationConditionalTag = exports.startNegationConditionalTag = exports.endConditionalTag = exports.startMsoConditionalTag = exports.startConditionalTag = void 0;
const startConditionalTag = '<!--[if mso | IE]>';
exports.startConditionalTag = startConditionalTag;
const startMsoConditionalTag = '<!--[if mso]>';
exports.startMsoConditionalTag = startMsoConditionalTag;
const endConditionalTag = '<![endif]-->';
exports.endConditionalTag = endConditionalTag;
const startNegationConditionalTag = '<!--[if !mso | IE]><!-->';
exports.startNegationConditionalTag = startNegationConditionalTag;
const startMsoNegationConditionalTag = '<!--[if !mso><!-->';
exports.startMsoNegationConditionalTag = startMsoNegationConditionalTag;
const endNegationConditionalTag = '<!--<![endif]-->';
exports.endNegationConditionalTag = endNegationConditionalTag;

function conditionalTag(content, negation = false) {
  return `
    ${negation ? startNegationConditionalTag : startConditionalTag}
    ${content}
    ${negation ? endNegationConditionalTag : endConditionalTag}
  `;
}

function msoConditionalTag(content, negation = false) {
  return `
    ${negation ? startMsoNegationConditionalTag : startMsoConditionalTag}
    ${content}
    ${negation ? endNegationConditionalTag : endConditionalTag}
  `;
}