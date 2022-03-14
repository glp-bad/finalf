import startOfMonth from '../../node_modules/date-fns/startOfMonth';
import endOfMonth   from '../../node_modules/date-fns/endOfMonth';
import format       from '../../node_modules/date-fns/format';
import urlList      from "../urlList";
import cssList      from "../cssList";
import factoryConfigControl   from "../js/configControlClass";
import {CheckCuiRo, CheckCnpRo, CheckIBAN}   from "../js/myCheck";
import {v4 as uuidv4} from '../../node_modules/uuid'

const appHelper = {
	install: (app, options) => {
        app.config.globalProperties.$url = {
            vueEnv:  process.env.VUE_APP_ENV,
            urlAppHost: process.env.VUE_APP_URL_HOST,
            urlAppLocal: process.env.VUE_APP_URL_LOCAL,
	        urlClientVue: "http://localhost:8080",
            urlList: urlList,
            getUrl: function (name) {
                let objFind = this.urlList.find( data => data.name === name);

                if(objFind === undefined){
                    return "url for [" +name+ "] not found"
                }

                return this.getBaseUrl() + '/' +objFind.url;
            },
            getBaseUrl: function () {
                let url = this.urlAppLocal;
                if(this.vueEnv == 'host'){
                    url = this.urlAppHost;
                }else if(this.vueEnv == 'local'){
	                url = this.urlAppLocal;
                }else{
                    // url = this.urlClientVue;
	                url = this.urlAppLocal;
                }
                return url;
            }
        },
            app.config.globalProperties.$css = {
                cssList: cssList,
                getCss: function (name) {
                    let objFind = this.cssList.find( data => data.name === name);

                    if(objFind === undefined){
                        return "css for [" +name+ "] not found"
                    }

                    return objFind;
                }
            },
            app.config.globalProperties.$calculate = {
                /**
                 *
                 * @param tipSuma
                 * @param suma
                 * @param percentTVA
                 * @param cantitate
                 * @returns {{sumaTVA: *, sumaCuTVA: *, pretUnitarFaraTva: *, sumaFaraTVA: *}}
                 */
                tva: function(tipSuma, suma, percentTVA, cantitate){

                    let percent =(percentTVA/100) + 1;

                    let sumaTVA = 0;
                    let sumaCuTVA = 0;
                    let sumaFaraTVA = 0;

                    if(tipSuma == 1){
                        // suma fara tva
                        sumaFaraTVA = suma;
                        sumaTVA = +( (suma * percent) - suma ).toFixed(2);
                        sumaCuTVA = +(suma * percent).toFixed(2);
                    }else{
                        // suma cu tva
                        sumaFaraTVA = +(suma/percent).toFixed(2);
                        sumaTVA = +(suma - sumaFaraTVA).toFixed(2);
                        sumaCuTVA = suma;
                    }

                    let pretUnitarFaraTva = +(sumaFaraTVA / cantitate).toFixed(4);

                    return {sumaFaraTVA: sumaFaraTVA, sumaTVA: sumaTVA, sumaCuTVA: sumaCuTVA, pretUnitarFaraTva: pretUnitarFaraTva};
                }
            },
            app.config.globalProperties.$vanilla = {
	            displayDivOnOff: function(div, dispaly){

	            	let valReturn = 'off';
	            	let displayMode = 'none';

		            if(div.style.display === 'none' || div.style.display === ''){
			            valReturn = 'on';
			            displayMode = dispaly;
		            }

		            div.style.display = displayMode;

		            return valReturn;
	            },
	            inputReadOnly: function(input, readonly){
	            	if(readonly){
			            input.setAttribute("readonly", true);
		            }else{
						input.removeAttribute("readonly");
		            }
	            },
        	    disableButton: function(htmlButton){
		            htmlButton.setAttribute('disabled',true);
		            htmlButton.classList.add('disable');                    // class name
	            },
	            enabledButton: function(htmlButton){
		            htmlButton.removeAttribute('disabled');
		            htmlButton.classList.remove('disable');                    // class name
	            },
	            centerDiv: function (divParent, divChild) {
	            	//parent and child: position: relative;

		            let boundingParent = divParent.getBoundingClientRect();
		            let boundingChild = divChild.getBoundingClientRect();

		            let topChild = (boundingParent.height/2) - (boundingChild.height/2) ;
		            let leftChild = (boundingParent.width/2) - (boundingChild.width/2) ;

		            //console.log('boundingParent = ', boundingParent);
		            //console.log('boundingChild = ', boundingChild );
		            //console.log('divChild = ', divChild );
		            //console.log('topChild = ', topChild );
		            //console.log('leftChild = ', leftChild, boundingParent.widht/2,  boundingChild.width/2 );

		            divChild.style.top =  topChild  + 'px';
		            divChild.style.left = leftChild  + 'px';

	            },
                removeClasses: function(htmlElementArray, className){
                    for (var i = 0; i < htmlElementArray.length; i++){
                        htmlElementArray[i].classList.remove(className);
                    }
                },
                addClasses: function(htmlElementArray, className){
                    for (var i = 0; i < htmlElementArray.length; i++){
                        htmlElementArray[i].classList.add(className);
                    }
                },
                dragDiv: function (container, header) {

                    let initialX = 0, initialY = 0, offsetX = 0, offsetY = 0;

                    header.onmousedown = dragMouseDown;

                    function dragMouseDown(e) {
                        e = e || window.event;
                        e.preventDefault();

                        initialX = e.clientX - offsetX;
                        initialY = e.clientY - offsetY;

                        document.onmousemove = elementDrag;
                        document.onmouseup = closeDragElement;

                        // console.log("dragMouseDown: "  + "initialX="+ initialX + " initialY="+initialY)

                    }

                    function elementDrag(e) {
                        e = e || window.event;
                        e.preventDefault();

                        let newX = e.clientX - initialX;
                        let newY = e.clientY - initialY;

                        offsetX = newX;
                        offsetY = newY;

                        //console.log("elementDrag: "  + "newX="+ newX + " newY="+newY)
                        container.style.transform = "translate3d(" + newX + "px, " + newY + "px, 0)";

                    }

                    function closeDragElement() {
                        document.onmouseup = null;
                        document.onmousemove = null;
                    }
                },
                /**
                 * @param objArray
                 * @param propNameId
                 * @param propId
                 * @param propNameReturn
                 * @returns {null}
                 */
                getAtributeValueFromArrayObject: function (objArray, propNameId, propId, propNameReturn){
                    let returnVal = null;
                    for (let i = 0; i < objArray.length; i++) {
                        if(objArray[i][propNameId] == propId){

                            if( propNameReturn === undefined || propNameReturn === null){
                                returnVal = objArray[i];
                            }else{
                                returnVal = objArray[i][propNameReturn];
                            }

                            break;
                        }
                    }
                    return returnVal;
                },

	            // for buttons.bt   paginate toolbar
	            generateButton(nrButton){

		            let buttonArray = new Array();
		            for(let i=0; i < nrButton; i++){
			            buttonArray.push(
				            {
					            id:i, caption: (i+1).toString(), selected: false, isDisable: false
				            }
			            );
		            }
		            return buttonArray;
	            },
                paginateArray: function (items, page, per_page, paginateLocal, totalRecords){
                    var page = page || 1,
                        per_page = per_page || 10,
                        offset = (page - 1) * per_page;

	                var  paginatedItems = null;
	                var  total_pages = null;
	                var  total = items.length;;

                    if(paginateLocal){
	                    paginatedItems = items.slice(offset).slice(0, per_page);
	                    total_pages = Math.ceil(total / per_page);
                    }else{
	                    paginatedItems = items;
	                    total_pages = Math.ceil(totalRecords / per_page);
	                    total = totalRecords;
                    }

                    return {
                        page: page,
                        per_page: per_page,
                        pre_page: page - 1 ? page - 1 : null,
                        next_page: (total_pages > page) ? page + 1 : null,
                        total: total,
                        total_pages: total_pages,
                        data: paginatedItems,
	                    buttons: {
		                    label: null,
		                    intializeButtonPage: false,
		                    bt: [
			                    {id:0, caption: '1', selected: false, isDisable: false},
			                    {id:1, caption: '2', selected: false, isDisable: false},
			                    {id:2, caption: '3', selected: false, isDisable: false},
			                    {id:3, caption: '4', selected: false,  isDisable: false},
			                    {id:4, caption: '5', selected: false, isDisable: false},
			                    {id:5, caption: '6', selected: false, isDisable: false}
		                    ]
	                    }
                    };
                }
            },


        app.config.globalProperties.$startEndCurrentMonth = function (formatDate) {

            let formatString = 'dd/MM/yyyy';
            if(formatDate != undefined){
                formatString = formatDate;
            }
            let curDate = new Date();
            let dataIn  = startOfMonth(curDate);
            let dataSf  = endOfMonth(curDate);
            return {monthIn: format(dataIn, formatString)  , monthSf: format(dataSf, formatString), currentDate: format(curDate, formatString), year: format(curDate, 'yyyy'), month: format(curDate, 'M')};
        }

        app.config.globalProperties.$datetime = {
            convertDataSqlFormatToView(data, formatDate){
                let formatString = 'dd/MM/yyyy';
                if(formatDate != undefined){
                    formatString = formatDate;
                }

                let curDate = new Date(data);
                return format(curDate, formatString);
            }
        }

        app.config.globalProperties.$check = {
            isNumber(nr){
                if (typeof nr === 'number' && !isNaN(nr)) {
                    return true;
                }

                return false;
            },
            isExistDate(dataCheck, yearCheck){
                 let data = dataCheck.year + "," + dataCheck.month + ","  + dataCheck.day;
                 let dataJs = new Date(data);
                 let returValid = false;

                //console.log(parseInt(dataCheck.year), parseInt(dataCheck.month), parseInt(dataCheck.day));
                //console.log(dataJs.getFullYear() , dataJs.getMonth()+1, dataJs.getDate());

                 if(!isNaN(dataJs.getDate())){

                     let year = true;
                     if(yearCheck){
                        if(parseInt(dataCheck.year) < 2022 || parseInt(dataCheck.year) > 2050){
                            year = false;
                        }
                     }
                     returValid = dataJs.getFullYear() === parseInt(dataCheck.year) && dataJs.getMonth()+1 === parseInt(dataCheck.month) && dataJs.getDate() === parseInt(dataCheck.day) && year;
                 }

                 return returValid;
            },
            isUndef (v) {
                return v === undefined || v === null
            },
	        intervalCheck(number, min, max){
		        if(number >= min && number <= max){
			        return true;
		        }
		        return false;
	        },
            lenghtMinMax(string, min, max){

                let sstring = 0;

                if(!this.isUndef(string)){
                    sstring = string.length;
                }

                let mmin  = parseInt(min);
                let mmax  = parseInt(max);

                if(mmin == NaN){
                    mmin = 0;
                }

                if(mmax == NaN){
                    mmax = 4503599627370495;
                }


                if(sstring >= min && sstring <= max){
                    return true;
                }
                return false;
            },
            validateForm(refs){
                for (const item in refs) {
                    if (refs[item].pConfig != undefined && typeof refs[item].pConfig.validate === "function") {
                        refs[item].pConfig.validate();
                    }
                }
            },
            checkCode (tip, cod) {
                let returnCheck = false;
                let check = null;

                if(tip == 'RO_CUI'){
                    check = new CheckCuiRo(cod);
                    returnCheck = check.check();

                }else if(tip == 'RO_CNP'){
                    check = new CheckCnpRo(cod);
                    let succes = check.check();
                    returnCheck = succes.succes;

                }else if(tip == 'RO_IBAN'){
                    check = new CheckIBAN(cod);
                    let succes = check.check();
                    returnCheck = succes.succes;
                }else{
                    console.error('tipul de verificare nu este definit ' + tip)
                }

                return returnCheck;
            }

        }


        app.config.globalProperties.$appServer = {
            /**
             *  sqlMessageResponse - from server
             * @param sqlMessageResponse
             */
            getHtmlSqlFormatMessage (sqlMessageResponse) {
                // succes, lastId, messages, errorMsg

                let msg = '';

                if(Array.isArray(sqlMessageResponse.messages)){
                    for(let i=0; i < sqlMessageResponse.messages.length; i++){
                        msg = msg + sqlMessageResponse.messages[i] + '<br>';
                    }
                }else{
                    msg = sqlMessageResponse.messages;
                }

                if(sqlMessageResponse.admin && !sqlMessageResponse.succes){
                    msg = msg + "<br><br>"+
                        sqlMessageResponse.errorMsg ;
                }

                return msg;

            }

        },

        app.config.globalProperties.$string = {
            splitStringIn (shir, charNumber){
                let arraySplit = [];
                let word = '';
                let countWord = 0;
                let firstNumberString = true;
                for(let i=0; i < shir.length; i++ ){

                    if(countWord < charNumber){
                        word += shir[i];
                        countWord++;
                    }else{
                        arraySplit.push(word);
                        if(firstNumberString){
                            firstNumberString = false;
                            charNumber--;
                        }
                         word = shir[i];
                        countWord = 0;
                    }
                }

                arraySplit.push(word);

                return arraySplit;
            }
        },
        app.config.globalProperties.$app = {
            getUuid () {
                return uuidv4();
            },
            getObjectReturnComponent (data) {
                return JSON.parse(JSON.stringify(data));
            },
            getFormMessageClass (field, caption, message) {
                return {
                    field: field,
                    caption: caption,
                    message: message
                }
            },
            /**
             *
             * @param messages  (array from getFormMessageClass)
             * @returns {string}
             */
            getHtmlFormatMessage (messages) {
                let msg = "";

                for(var i=0; i < messages.length; i++ ){
                    msg = msg+
                        "<b>" + messages[i].caption + ": &nbsp;</b>"+
                        messages[i].message +  "<br>";
                }

                return msg;

            },
            cfgInputField(id, sizeField, width){
                let cfg = factoryConfigControl.getConfig(factoryConfigControl.INPUT_FIELD);
                cfg.setBaseConfig(id, sizeField, width);
                return cfg;
            },
            cfgInputDateTimeField(id, sizeField, width){
                let cfg = factoryConfigControl.getConfig(factoryConfigControl.INPUT_DATETIME);
                cfg.setBaseConfig(id, sizeField, width);
                cfg.setMaska("##/##/####");             // default day/month/year
                return cfg;
            },
            cfgTextFIeld(){
                return { id: "",
                    minLength: 0,
                    maxLength: 0,
                    validate: "",
                    ref: "",
                    maska: "",
                    caption: "",
                    mandatory: false,
                    sizeField: 0,
                    setIdAndRef: function (id) {
                        this.id = id;
                        this.ref = id+'Ref';
                    }
                };

            },
            cfgCheckBox(id, defaultValue) {
                let cfg = factoryConfigControl.getConfig(factoryConfigControl.CHECK_BOX);
                cfg.setBaseConfig(id, null);
                cfg.setDefaultValue(defaultValue);
                return cfg;
            },
            cfgSelectSimple(id, url, width) {
                let cfg = factoryConfigControl.getConfig(factoryConfigControl.SELECT_SIMPLE);
                cfg.setBaseConfig(id, width);
                cfg.setUrl(url);
                cfg.setDefaultValue({id: 0, text: ''});

                return cfg;
            },
	        cfgSelectSearch(id, url, width) {
		        let cfg = factoryConfigControl.getConfig(factoryConfigControl.SELECT_SEARCH);
		        cfg.setBaseConfig(id, width);
		        cfg.setUrl(url);
		        cfg.setDefaultValue({id: 0, text: ''});

		        return cfg;
	        },
            cfgInputIBAN(id, width) {
                let cfg = factoryConfigControl.getConfig(factoryConfigControl.INPUT_IBAN);
                cfg.setBaseConfig(id, width);
                return cfg;
            }
        }



	}


}


export default appHelper;
