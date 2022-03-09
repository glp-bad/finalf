<template>
    <validate-window ref="validateWindowRef"
                     :cWidth=500
                     :cHeight=200
                     :cTypeWindows=1
    ></validate-window>

    <validate-window ref="infoWindowRef"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=5
    ></validate-window>

    <validate-window ref="redWindowRef"
                     :cWidth=400
                     :cHeight=200
                     :cTypeWindows=6
    ></validate-window>

    <validate-window ref="refYesNo"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButton"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>
            <table class="ff-form-table">
                <tr>
                    <td class="control">
                        <my-radio-button
                                :ref = this.cfgtime.TIP_PLATA.ref
                                :pConfig = this.cfgtime.TIP_PLATA
                                @emitClickTipPlata = 'emitClickTipPlata'
                        ></my-radio-button>
                    </td>
                    <td class="label-left bold" colspan="1">
                        &nbsp;&nbsp;&nbsp;
                        <label :for=this.cfgtime.CTR_DATA_CHELTUIALA.id>{{this.cfgtime.CTR_DATA_CHELTUIALA.caption}} &nbsp;</label>
                        <my-datetime
                                :ref = this.cfgtime.CTR_DATA_CHELTUIALA.ref
                                :pConfig = this.cfgtime.CTR_DATA_CHELTUIALA
                        ></my-datetime>
                    </td>

                    <td class="label-left bold">
                        &nbsp;
                        <label :for=this.cfgtime.CTR_NR_DOCUMENT.id>{{this.cfgtime.CTR_NR_DOCUMENT.caption}}</label></td>
                    <td>
                        <input-field
                                :ref = this.cfgtime.CTR_NR_DOCUMENT.ref
                                :pConfig = this.cfgtime.CTR_NR_DOCUMENT
                        ></input-field>
                        &nbsp;
                        &nbsp;
                    </td>
                    <td class="label-left bold" colspan="2">
                        <my-dropdown-simple
                                :pConfig = this.cfgtime.CTR_DOCUMENT_TYPE
                                :ref = this.cfgtime.CTR_DOCUMENT_TYPE.ref
                        ></my-dropdown-simple>
                    </td>
                    <td class="label-left bold" colspan="2">
                        <my-dropdown-simple
                                :pConfig = this.cfgtime.CTR_TIP_CHELTUIELI
                                :ref = this.cfgtime.CTR_TIP_CHELTUIELI.ref
                        ></my-dropdown-simple>
                    </td>
                </tr>
                <tr>

                    <td class="label-right bold">
                        &nbsp;
                        <label :for=this.cfgtime.CTR_PARTNER_LIST.id>{{this.cfgtime.CTR_PARTNER_LIST.caption}}</label></td>

                    <td class="control" colspan="4">
                        <my-dropdown-search :ref = this.cfgtime.CTR_PARTNER_LIST.ref
                                            :pConfig = this.cfgtime.CTR_PARTNER_LIST
                        ></my-dropdown-search>
                    </td>

                    <td class="control">
                        <div class="toolbar-icon-inline">
                            <div class="divButton">
                                &nbsp;&nbsp;
                                <my-button  :ref=this.cfgtime.REF_BUTTON_ADD_CHELT @click="this.addNewChelt" :heightButton=22 :buttonType=2 title="adauga factura" :style="this.cfgtime.ICON_ADD_CHELT.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_ADD_CHELT) size="1x" />
                                </my-button>
                            </div>

                            <div class="divButton">
                                <my-button  :ref=this.cfgtime.REF_BUTTON_REMOVE_CHELT @click="this.deleteChelt" :heightButton=22 :buttonType=2 title="sterg factura" :style="this.cfgtime.ICON_REMOVE_CHELT.colorStyle">
                                    <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REMOVE_CHELT) size="1x" />
                                </my-button>
                            </div>

                        </div>
                    </td>
                </tr>
            </table>
        </template>
        <template v-slot:slotButton>
        </template>
    </form-tab>
</template>

<script>
    import AlertWindow      from "@/components/base/AlertWindow.vue";
    import FormTab          from "@/components/base/FormTab.vue";
    import RadioButton      from "@/components/base/RadioButton.vue";
    import InputDateTime    from "@/components/base/InputDateTime.vue";
    import InputField       from "@/components/base/InputField.vue";
    import DropDownSimple   from "@/components/base/DropDownSimple.vue";
    import DropDownSearch   from "@/components/base/DropDownSearch.vue"
    import Button           from "@/components/base/Button";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
	        'my-radio-button': RadioButton,
	        'my-datetime': InputDateTime,
	        'input-field': InputField,
	        'my-dropdown-simple': DropDownSimple,
	        'my-dropdown-search': DropDownSearch,
            'my-button': Button
        },
        name: "form-chletuiala-new",
        created() {
            this.REF_FORM = 'refCheltuialaNew';
            this.cfgtime = {
                REF_BUTTON_ADD_CHELT:     'refAddChelt',
                REF_BUTTON_REMOVE_CHELT:  'refRemoveChelt',
	            TIP_PLATA: {
		            id: 'refTipPlata',
		            ref: 'refTipPlata',
		            caption: 'Tip plata',
		            alignment: this.$constRadioButton.ALIGNMENT_H,
		            name: 'tipPlata',
		            emit: 'emitClickTipPlata',
		            buttons:[
			            {id: 1, value: '1', caption: 'Numerar', check: true, disableOption: false },
			            {id: 2, value: '2', caption: 'Banca', check: false, disableOption: false }
		            ]
	            },
                CTR_DATA_CHELTUIALA: this.cfgDataCheltuiala(),
	            CTR_NR_DOCUMENT: this.cfgNrDoc(),
	            CTR_DOCUMENT_TYPE: this.cfgDocumentType(),
	            CTR_TIP_CHELTUIELI: this.cfgCheltuieliType(),
	            CTR_PARTNER_LIST: this.cfgDropDownPartner(),
                ICON_ADD_CHELT:            this.$constComponent.ICON_PLUS_SQUARE("blue"),
                ICON_REMOVE_CHELT:        this.$constComponent.ICON_MINUS_SQUARE("red")
            },
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
                yesNoMethod: 'methodName',
                post: { idPk: null, field: {}, sqlAction: null}
            }
        },
        emits: ['emitModel'],
        mounted () {
        },
        methods: {
            addNewChelt: function (){
            },
            deleteChelt: function (){
            },
	        emitClickTipPlata: function (){
            },
            setModeForm: function (mode) {
                this.runtime.mode = mode;
                if(this.runtime.mode == this.$constFROM.MODE_EDIT) {}

                if(this.runtime.mode == this.$constFROM.MODE_NEW) {}
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){
                    this.runtime.sendDataToServer = true;
                    this[this.runtime.yesNoMethod].apply();
                }else{
                    this.runtime.sendDataToServer = false;
                }
            },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
	        cfgDataCheltuiala: function(){
		        let cfg = this.$app.cfgInputDateTimeField("dataCheltuiala", 11, 80);
		        cfg.setValidateFunction(this.validateDocumentDate);
		        cfg.setCaption("Data");
		        cfg.setMandatory(true);
		        return cfg;
	        },
	        cfgNrDoc: function(){
		        let cfg = this.$app.cfgInputField("nrDoc", null, 120);
		        cfg.setValidate(2,15);
		        cfg.setValidateFunction(this.validateNrDoc);
		        cfg.setCaption("Nr. document");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
	        cfgCheltuieliType: function (){
		        let cfg = this.$app.cfgSelectSimple('nomTypeCheltuieli', this.$url.getUrl('nomTipCheltuieli'), 200);
		        cfg.setValidateFunction(this.validateCheltuieliType);
		        cfg.setCaption("Tip cheltuiala");
		        cfg.setMandatory(true);
		        cfg.setPlaceHolder('... (tip cheltuiala)');
		        cfg.setDefaultValue({id: 0, text: '... (tip cheltuiala)'});
		        return cfg;
            },
	        cfgDocumentType: function(){
		        let cfg = this.$app.cfgSelectSimple('nomDocumentType', this.$url.getUrl('nomDocumentTipe'), 200);
		        cfg.setValidateFunction(this.validateInvoiceType);
		        cfg.setCaption("Tip document");
		        cfg.setMandatory(true);
		        cfg.setPlaceHolder('... (tip document)');
		        cfg.setDefaultValue({id: 0, text: '... (tip document)'});
		        return cfg;
	        },
	        cfgDropDownPartner: function(){
		        let cfg = this.$app.cfgSelectSearch('nomPartner', this.$url.getUrl('listPartener'), 450);
		        cfg.setValidateFunction(this.validatePartner);
		        cfg.setCaption("Furnizor");
		        cfg.setMandatory(true);
		        return cfg;
	        },
        },
        data () {
            return {
            }
        }
    }

</script>

<style scoped></style>
