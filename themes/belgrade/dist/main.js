/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * @file
 * Belgrade theme main JS file.
 *
 */
(function ($, Drupal) {
  'use strict'; // Initiate all Toasts on page.

  Drupal.behaviors.belgradeToast = {
    attach: function attach(context, settings) {
      $('.toast', context).once('initToast').each(function () {
        $(this).toast("show");
      });
    }
  }; // Accordion buttons containing Edit links.

  Drupal.behaviors.accordionButtonLinks = {
    attach: function attach(context, settings) {
      $('.fieldset-legend.accordion-button a', context).once().on('click', function (event) {
        window.location = $(this).attr('href');
        event.preventDefault();
      });
    }
  }; // Collapse and accordion if a field is required.

  Drupal.behaviors.focusRequired = {
    attach: function attach(context, settings) {
      var inputs = document.querySelectorAll('form .accordion input');
      [].forEach.call(inputs, function (input) {
        input.addEventListener('invalid', function (e) {
          var accordion = input.closest(".collapse");
          $(accordion).collapse('show');
        });
      });
    }
  };
})(jQuery, Drupal);

/***/ }),

/***/ "./src/scss/color.scss":
/*!*****************************!*\
  !*** ./src/scss/color.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/commerce/commerce-demo--frontpage.scss":
/*!*********************************************************!*\
  !*** ./src/scss/commerce/commerce-demo--frontpage.scss ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/commerce/commerce_cart_block.scss":
/*!****************************************************!*\
  !*** ./src/scss/commerce/commerce_cart_block.scss ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/commerce/commerce_checkout-progress.scss":
/*!***********************************************************!*\
  !*** ./src/scss/commerce/commerce_checkout-progress.scss ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/commerce/commerce_wishlist.scss":
/*!**************************************************!*\
  !*** ./src/scss/commerce/commerce_wishlist.scss ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/commerce/product.images.scss":
/*!***********************************************!*\
  !*** ./src/scss/commerce/product.images.scss ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/components/icons.scss":
/*!****************************************!*\
  !*** ./src/scss/components/icons.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/main.scss":
/*!****************************!*\
  !*** ./src/scss/main.scss ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/product-teaser/belgrade.scss":
/*!***********************************************!*\
  !*** ./src/scss/product-teaser/belgrade.scss ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/product-teaser/zoom.scss":
/*!*******************************************!*\
  !*** ./src/scss/product-teaser/zoom.scss ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./src/js/main.js ./src/scss/product-teaser/belgrade.scss ./src/scss/product-teaser/zoom.scss ./src/scss/commerce/commerce-demo--frontpage.scss ./src/scss/commerce/commerce_cart_block.scss ./src/scss/commerce/commerce_checkout-progress.scss ./src/scss/commerce/commerce_wishlist.scss ./src/scss/commerce/product.images.scss ./src/scss/components/icons.scss ./src/scss/main.scss ./src/scss/color.scss ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/js/main.js */"./src/js/main.js");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/product-teaser/belgrade.scss */"./src/scss/product-teaser/belgrade.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/product-teaser/zoom.scss */"./src/scss/product-teaser/zoom.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/commerce/commerce-demo--frontpage.scss */"./src/scss/commerce/commerce-demo--frontpage.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/commerce/commerce_cart_block.scss */"./src/scss/commerce/commerce_cart_block.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/commerce/commerce_checkout-progress.scss */"./src/scss/commerce/commerce_checkout-progress.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/commerce/commerce_wishlist.scss */"./src/scss/commerce/commerce_wishlist.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/commerce/product.images.scss */"./src/scss/commerce/product.images.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/components/icons.scss */"./src/scss/components/icons.scss");
__webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/main.scss */"./src/scss/main.scss");
module.exports = __webpack_require__(/*! /Users/ibuisic/Documents/Projects/commerce-demo/web/themes/custom/belgrade/src/scss/color.scss */"./src/scss/color.scss");


/***/ })

/******/ });