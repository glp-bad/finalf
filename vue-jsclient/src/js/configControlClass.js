class ConfigControl {
    id = null;
    name = null;
    ref  = null;
    mandatory = false;
    validate = null;            // function form call
    caption= null;
    sizeField= 0;               // lungimea controlului, width filed
    defaultValue= null;
    disabled= false;
    width= null;               // replace sizeField
    readOnly = false;
    emit = null;

    setBaseConfig(id, sizeField, width) {
        this.id = id;
        this.name = 'name_' + id;
        this.ref = 'ref_' + id;

	    if(width === undefined || width === null){
		    this.sizeField = sizeField;
		    this.width = null;
	    }else{
		    this.sizeField = 0;
		    this.width = width + 'px';
	    }
    }
    setCaption(caption) {
        this.caption = caption;
    }
    setValidateFunction(functionName) {
        this.validate = functionName;
    }
    setMandatory(madatory){
        this.mandatory = madatory;
    }
    setDefaultValue(value){
        this.defaultValue = value;
    }
    getDefaultValue(){
        return this.defaultValue;
    }
    setDisable(disable){
        this.disabled = disable;
    }

    setEmit(emit){
        this.emit = emit;
    }

}



class CheckBox extends ConfigControl{
}
class InputIBAN extends ConfigControl{}

class SelectSimple extends ConfigControl{
    // defaultValue: {id: 0, text: ''},

    placeHolder = '...select option';

    url= '#';
    setUrl(url){
        this.url = url;
    }

    setPlaceHolder(text) {
        this.placeHolder = text;
    }
}


class SelectSearch extends ConfigControl{
	// defaultValue: {id: 0, text: ''},

	url= '#';
	dataMethod = 'server';       // implict server
	placeHolder = '...search';
	setUrl(url){
		this.url = url;
	}
}

class InputField extends ConfigControl
{
    minLength= 0;
    maxLength= 0;
    maska= "";
    placeHolder = "...";
    emitKeyUp = null;
    emitKeyDown = null;

    setEmitKeyUp(emit) {
        this.emitKeyUp = emit;
    }

    setEmitKeyDown(emit) {
        this.emitKeyDown = emit;
    }

    setMaska(maska) {
        this.maska = maska;
    }
    setValidate(min, max) {
        this.minLength = min;
        this.maxLength = max;
    }
    setPlaceHolder(text) {
        this.placeHolder = text;
    }

}


class InputDateTimeField extends ConfigControl
{
    maska= "";
    placeHolder="dd/MM/yyyy";
    dateShowDefault = 'currentDate';    // currentDate, firstDayMonth, lastDayMonth
    setMaska(maska) {
        this.maska = maska;
    }
    setPlaceHolder(text) {
        this.placeHolder = text;
    }

    // DATE_CURRENT: 'currentDate',
    setShowDefault(type) {
        this.dateShowDefault = type;
    }

}


export default class factoryConfigControl {
    static INPUT_FIELD = 'inputField';
    static CHECK_BOX   = 'checkBox';
    static SELECT_SIMPLE   = 'selectSimple';
	static SELECT_SEARCH   = 'selectSearch';
    static INPUT_IBAN      = 'inputIban';
    static INPUT_DATETIME  = 'inputDatetime';

    static getConfig(control){
        switch (control)
        {
            case factoryConfigControl.INPUT_FIELD:
                return new InputField();
                break;
            case factoryConfigControl.CHECK_BOX:
                return new CheckBox();
                break;
            case factoryConfigControl.SELECT_SIMPLE:
                return new SelectSimple();
                break;
	        case factoryConfigControl.SELECT_SEARCH:
		        return new SelectSearch();
		        break;
            case factoryConfigControl.INPUT_IBAN:
                return new InputIBAN();
                break;
            case factoryConfigControl.INPUT_DATETIME:
                return new InputDateTimeField();
                break;
            default:
                console.error("!!! ATENTIE !!! nu exista configurare pentru controlul " + control);
       }



    }

}
