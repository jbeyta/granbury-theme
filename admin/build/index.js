/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/OfficeSearch.js":
/*!********************************!*\
  !*** ./src/js/OfficeSearch.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ OfficeSearch; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);


class OfficeSearch extends (react__WEBPACK_IMPORTED_MODULE_1___default().Component) {
  constructor(props) {
    super(props);
    this.searchByName = this.searchByName.bind(this);
    this.updateSelectedOffice = this.updateSelectedOffice.bind(this);
    this.updateOfficeName = this.updateOfficeName.bind(this);
    this.state = {
      results: [],
      isLoaded: false,
      nameSearch: '',
      selectedOffice: '',
      selectedOfficeName: ''
    };
  }
  componentDidMount() {
    if (this.props.cwmbcwoffice) {
      this.setState({
        selectedOffice: this.props.cwmbcwoffice
      });
    }
    fetch(endpoints.justoffices).then(res => res.json()).then(result => {
      this.setState({
        isLoaded: true,
        results: result
      });
      this.updateOfficeName(this.props.cwmbcwoffice);
    }, error => {
      console.log(error);
      this.setState({
        isLoaded: true
      });
    });
  }
  searchByName(e) {
    this.setState({
      nameSearch: e.currentTarget.value
    });
  }
  updateSelectedOffice(e) {
    let officeID = '';
    if (e.currentTarget.dataset.agentid) {
      officeID = e.currentTarget.dataset.agentid;
    }
    if (e.currentTarget.value) {
      officeID = e.currentTarget.value;
    }
    this.setState({
      selectedOffice: officeID,
      nameSearch: ''
    });
    this.updateOfficeName(officeID);
  }
  updateOfficeName(officeID) {
    const matches = this.state.results.filter(office => {
      return office.officemlsid == officeID;
    });
    if (matches.length) {
      const office = matches[0];
      this.setState({
        selectedOfficeName: office.name
      });

      // update page title input
      const pageTitleInput = document.querySelector('#title');
      if (pageTitleInput) {
        pageTitleInput.value = office.name;
      }
    }
  }
  render() {
    const {
      results,
      isLoaded,
      selectedOffice,
      selectedOfficeName
    } = this.state;
    const {
      searchByName,
      updateSelectedOffice
    } = this;
    if (!isLoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "loading"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Building List"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "animation"
      }));
    } else {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "office-search-inner"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "inner"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "input-item"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "input-mother"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
        type: "text",
        placeholder: "Search for a Office",
        value: this.state.nameSearch,
        onChange: searchByName
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
        className: "search-results"
      }, results.filter(office => !!this.state.nameSearch && office.name.toLowerCase().includes(this.state.nameSearch.toLowerCase())).map((office, key) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
        onClick: updateSelectedOffice,
        "data-agentid": office.officemlsid,
        key: key
      }, office.name))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "input-item"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
        type: "hidden",
        name: "_office_name",
        value: selectedOfficeName
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
        id: "_office",
        name: "_office",
        value: selectedOffice,
        onChange: updateSelectedOffice
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
        value: ""
      }, "Select a Office"), results.map((office, key) => {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
          value: office.officemlsid,
          key: key
        }, office.name);
      })))));
    }
  }
}

/***/ }),

/***/ "./src/js/RealtorSearch.js":
/*!*********************************!*\
  !*** ./src/js/RealtorSearch.js ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ RealtorSearch; }
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);


class RealtorSearch extends (react__WEBPACK_IMPORTED_MODULE_1___default().Component) {
  constructor(props) {
    super(props);
    this.searchByName = this.searchByName.bind(this);
    this.updateSelectedRealtor = this.updateSelectedRealtor.bind(this);
    this.updateRealtorName = this.updateRealtorName.bind(this);
    this.state = {
      results: [],
      isLoaded: false,
      nameSearch: '',
      selectedRealtor: ''
    };
  }
  componentDidMount() {
    if (this.props.cwmbcwrealtor) {
      this.setState({
        selectedRealtor: this.props.cwmbcwrealtor
      });
    }
    fetch(endpoints.justrealtors).then(res => res.json()).then(result => {
      this.setState({
        isLoaded: true,
        results: result
      });
    }, error => {
      console.log(error);
      this.setState({
        isLoaded: true
      });
    });
  }
  searchByName(e) {
    this.setState({
      nameSearch: e.currentTarget.value
    });
  }
  updateSelectedRealtor(e) {
    let agentSlug = '';
    if (e.currentTarget.dataset.agentid) {
      agentSlug = e.currentTarget.dataset.agentid;
    }
    if (e.currentTarget.value) {
      agentSlug = e.currentTarget.value;
    }
    this.setState({
      selectedRealtor: agentSlug,
      nameSearch: ''
    });
    this.updateRealtorName(agentSlug);
  }
  updateRealtorName(agentSlug) {
    const matches = this.state.results.filter(agent => {
      return agent.slug == agentSlug;
    });
    if (matches.length) {
      const agent = matches[0];

      // update page title input
      const pageTitleInput = document.querySelector('#title');
      if (pageTitleInput) {
        pageTitleInput.value = agent.first_name + ' ' + agent.last_name + ' - ' + agent.office_name;
      }
    }
  }
  render() {
    const {
      results,
      isLoaded,
      nameSearch,
      selectedRealtor
    } = this.state;
    const {
      searchByName,
      updateSelectedRealtor
    } = this;
    if (!isLoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "loading"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Building List"), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "animation"
      }));
    } else {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "realtor-search-inner"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "inner"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "input-item"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "input-mother"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
        type: "text",
        placeholder: "Search for a Realtor",
        value: this.state.nameSearch,
        onChange: searchByName
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
        className: "search-results"
      }, results.filter(realtor => !!this.state.nameSearch && (realtor.first_name.toLowerCase().includes(this.state.nameSearch.toLowerCase()) || realtor.last_name.toLowerCase().includes(this.state.nameSearch.toLowerCase()))).map((realtor, key) => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
        onClick: updateSelectedRealtor,
        "data-agentid": realtor.slug,
        key: key
      }, realtor.first_name, " ", realtor.last_name, " - ", realtor.office_name))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "input-item"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
        id: "_realtor",
        name: "_realtor",
        value: selectedRealtor,
        onChange: updateSelectedRealtor
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
        value: ""
      }, "Select a Realtor"), results.map((realtor, key) => {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
          value: realtor.slug,
          key: key
        }, realtor.first_name, " ", realtor.last_name, " - ", realtor.office_name);
      })))));
    }
  }
}

/***/ }),

/***/ "./src/js/office-search.js":
/*!*********************************!*\
  !*** ./src/js/office-search.js ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _OfficeSearch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./OfficeSearch */ "./src/js/OfficeSearch.js");




const officeDir = document.getElementById('cw-office-search-mother');
if (officeDir) {
  const cwmbcwoffice = officeDir.dataset.cwmbcwoffice;
  react_dom__WEBPACK_IMPORTED_MODULE_2___default().render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_OfficeSearch__WEBPACK_IMPORTED_MODULE_3__["default"], {
    cwmbcwoffice: cwmbcwoffice
  }), officeDir);
}

/***/ }),

/***/ "./src/js/realtor-import.js":
/*!**********************************!*\
  !*** ./src/js/realtor-import.js ***!
  \**********************************/
/***/ (function() {

/* global jQuery: false, endpoints: false */

const importButton = document.querySelector('#realtor-import');
if (importButton) {
  importButton.addEventListener('click', function () {
    jQuery.ajax({
      url: endpoints.manualimport,
      type: 'GET',
      success: function (data) {
        console.log('success');
        console.log(data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log('jqXHR: ', jqXHR);
        console.log('textStatus: ', textStatus);
        console.log('errorThrown: ', errorThrown);
        console.log('status: ', jqXHR.status);
        console.log('responseText: ', jqXHR.responseText);
      }
    });
  });
}

/***/ }),

/***/ "./src/js/realtor-search.js":
/*!**********************************!*\
  !*** ./src/js/realtor-search.js ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _RealtorSearch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./RealtorSearch */ "./src/js/RealtorSearch.js");




const realtorDir = document.getElementById('cw-realtor-search-mother');
if (realtorDir) {
  const cwmbcwrealtor = realtorDir.dataset.cwmbcwrealtor;
  react_dom__WEBPACK_IMPORTED_MODULE_2___default().render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_RealtorSearch__WEBPACK_IMPORTED_MODULE_3__["default"], {
    cwmbcwrealtor: cwmbcwrealtor
  }), realtorDir);
}

/***/ }),

/***/ "./src/scss/index.scss":
/*!*****************************!*\
  !*** ./src/scss/index.scss ***!
  \*****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ (function(module) {

"use strict";
module.exports = window["ReactDOM"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _scss_index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./scss/index.scss */ "./src/scss/index.scss");
/* harmony import */ var _js_realtor_search_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./js/realtor-search.js */ "./src/js/realtor-search.js");
/* harmony import */ var _js_office_search_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./js/office-search.js */ "./src/js/office-search.js");
/* harmony import */ var _js_realtor_import_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./js/realtor-import.js */ "./src/js/realtor-import.js");
/* harmony import */ var _js_realtor_import_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_js_realtor_import_js__WEBPACK_IMPORTED_MODULE_3__);




}();
/******/ })()
;
//# sourceMappingURL=index.js.map