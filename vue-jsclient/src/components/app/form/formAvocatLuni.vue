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

    <validate-window ref="refYesNoInsert"
                     :cWidth=300
                     :cHeight=200
                     :cTypeWindows=3
                     @emitYesNoButton = "emitYesNoButtonInsert"
    ></validate-window>

    <form-tab :ref = this.REF_FORM>
        <template v-slot:slotTitle>
        </template>
        <template v-slot:slotContent>

            <table class="ff-form-table">
                <tr>
                    <td class="label-left bold">
                        <label :for=this.cfgtime.FIELD_YEAR.id>{{this.cfgtime.FIELD_YEAR.caption}}</label></td>

                    <td class="control">
                        <input-field
                                :ref = this.cfgtime.FIELD_YEAR.ref
                                :pConfig = this.cfgtime.FIELD_YEAR
                        ></input-field>
                    </td>
                    <td class="control">
                        <div class="prime-button last-button">
                            &nbsp;
                            <my-button  :ref=this.cfgtime.REF_BUTTON_REFRESH @click="this.clickRefresMonthList" :heightButton=22 :buttonType=2 title="refresh lista" :style="this.cfgtime.ICON_REFRESH.colorStyle">
                                <font-awesome-icon :icon=this.$constComponent.cfgIconPicture(this.cfgtime.ICON_REFRESH) size="1x" />
                            </my-button>
                        </div>
                    </td>

                    <td class="label-left bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                    <td class="label-left bold">
                        <label :for=this.cfgtime.FIELD_MONTH.id>{{this.cfgtime.FIELD_MONTH.caption}}</label></td>

                    <td class="control">
                        <input-field
                                :ref = this.cfgtime.FIELD_MONTH.ref
                                :pConfig = this.cfgtime.FIELD_MONTH
                        ></input-field>
                    </td>
                    <td class="control">
                        <div class="buttons">
                            &nbsp;
                            <my-button @click="this.privateServerInsertMonth" :heightButton=22 :buttonType=0 title="modific date partener">{{this.captionButton}}</my-button>
                        </div>
                    </td>
                </tr>
            </table>

            <br>


            <my-list
                :ref = this.cfgtime.LIST_MONTH.ref
                :pConfig = this.cfgtime.LIST_MONTH
                @emitCheckLunaInchisa = 'emitCheckLunaInchisa'
            ></my-list>

                <table class="ff-form-table">
                </table>

        </template>
        <template v-slot:slotButton>
        </template>


    </form-tab>
</template>

<script>
    import AlertWindow  from "@/components/base/AlertWindow.vue";
    import FormTab      from "@/components/base/FormTab.vue";
    import Button       from "@/components/base/Button";
    import Lista        from "@/components/base/Lista";
    import InputField   from "@/components/base/InputField.vue";

    export default {
        components: {
            'form-tab': FormTab,
            'validate-window': AlertWindow,
            'my-button': Button,
            'my-list': Lista,
	        'input-field': InputField
        },
        name: "form-avocat-luni",
        created() {
            this.REF_FORM = 'refFormLuni';
            this.runtime = {
                mode: this.$constFROM.MODE_EDIT,
                sendDataToServer: false,
                message: [],
                post: { idPk: null, field: {}, sqlAction: null},
	            postInsert: { idPk: null, field: {}, sqlAction: null},
                yearList: 0
            };
            this.cfgtime = {
            	REF_BUTTON_REFRESH: 'refButtonRefresh',
	            ICON_REFRESH: this.$constComponent.ICON_REFRESH("green"),
            	FIELD_YEAR: this.cfgYearField(),
	            FIELD_MONTH: this.cfgMonthField(),
                URL_CHECK_MONTH:  this.$url.getUrl('checkMonth'),
	            URL_INSERT_MONTH: this.$url.getUrl('insertMonth'),
                LIST_MONTH : {
                    ref: 'refMonthList',
                    header: [
                        this.$constList.getHeader(1, 'Luna',  150, 'nLuna', this.$constList.HEADER.CAPTION_TYPE_FIELD, this.$constComponent.ALIGN_TEXT_CENTER ),
                        this.$constList.getHeader(2, 'Luna inchisa', 100, 'null', this.$constList.HEADER.CAPTION_TYPE_ACTION)
                    ],

                    recordActionButon: [
                        // this.$constList.getActionButton(4, 'sterg articol', 'emitStergArticol', this.$constGrid.ICON_DELETE, this.$constList.ACTION_BUTTON.TYPE_BUTTON, null)
                        this.$constList.getActionButton(9, 'luna inchisa', 'emitCheckLunaInchisa', null, this.$constList.ACTION_BUTTON.TYPE_CHECKBOX, this.$app.cfgCheckBox('lunaInchisa', false)),   // poate fi un singur checkbox pe linie, trebuie setat si filedNameForCheckBox, campul poate fi doar 1 si 0
                        // this.$constList.getActionButton(6, 'adresa implicita', 'emitCheckBox', this.$constGrid.getIcon('fas','skull', '#adad00'))
                    ],
                    cfg: { urlData: 'monthList',
                           loadOnCreate: false,
                           filedNameForCheckBox: 'inchisa',
                           emitListRowSelection: 'emitListRowSelection',
                           headerLenghtActivate: true,                         // tine cont de lungimea coloanelor setate in header
                           heightList: 350
                    }
                },
            };

        },
        emits: ['emitNewRecord'],
        mounted () {

        	let dateTime = this.$startEndCurrentMonth();
	        this.runtime.yearList = dateTime.year;

	        this.$refs[this.cfgtime.FIELD_YEAR.ref].setValue(this.runtime.yearList);
	        this.$refs[this.cfgtime.FIELD_MONTH.ref].setValue(dateTime.month);
        },
        methods: {
	        privateServerInsertMonth(){
		        if(this.validateForm()){
			        this.$refs.validateWindowRef.show();

			        return false;
		        }

		        if(!this.runtime.sendDataToServer) {
			        this.$refs.refYesNoInsert.setCaption("Inregistrez");
			        this.$refs.refYesNoInsert.setMessage('Inregistrez luna in baza de date?');
			        this.$refs.refYesNoInsert.show();
		        }

		        if(this.runtime.sendDataToServer) {
			        this.runtime.sendDataToServer = false;
			        this.$refs[this.REF_FORM].showModal(true);

			        this.axios
				        .post(this.cfgtime.URL_INSERT_MONTH, this.runtime.postInsert)
				        .then(response => {

					        if (response.data.succes){
						        //this.getDataPartener(this.post.idPk);
						        //this.$refs.infoWindowRef.setCaption("Succes");
						        //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
						        //this.$refs.infoWindowRef.show();
					        }
					        else {
						        this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
						        this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
						        this.$refs.validateWindowRef.show();
					        }

				        })
				        .catch(error => console.log(error))
				        .finally(() => {
					        // this.showList({idPartner: this.runtime.postAccount.idPartner});
					        this.refreshListLuniInchise();
					        this.$refs[this.REF_FORM].showModal(false);
				        });

		        }
            },
        	privateServerCheckMonth(){
                let msg = '';

        		if(this.runtime.post.field.checkValue){
			        msg = 'Blochez luna selectata ?';
                }else{
			        msg = 'Deblochez luna selectata ?';
                }


		        if(!this.runtime.sendDataToServer) {
			        this.$refs.refYesNo.setCaption("Luna in lucru");
			        this.$refs.refYesNo.setMessage(msg);
			        this.$refs.refYesNo.show();
		        }

		        if(this.runtime.sendDataToServer) {
			        this.runtime.sendDataToServer = false;
			        this.$refs[this.REF_FORM].showModal(true);

			        this.axios
				        .post(this.cfgtime.URL_CHECK_MONTH, this.runtime.post)
				        .then(response => {

					        if (response.data.succes){
						        //this.getDataPartener(this.post.idPk);
						        //this.$refs.infoWindowRef.setCaption("Succes");
						        //this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
						        //this.$refs.infoWindowRef.show();
					        }
					        else {
						        this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
						        this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
						        this.$refs.validateWindowRef.show();
					        }

				        })
				        .catch(error => console.log(error))
				        .finally(() => {
					        // this.showList({idPartner: this.runtime.postAccount.idPartner});
					        this.refreshListLuniInchise();
					        this.$refs[this.REF_FORM].showModal(false);
				        });
		        }
            },
	        clickRefresMonthList: function(){
		        this.runtime.yearList = this.$refs[this.cfgtime.FIELD_YEAR.ref].getValue();
		        this.refreshListLuniInchise();
            },
        	refreshListLuniInchise: function(){
        	    this.$refs[this.cfgtime.LIST_MONTH.ref].showList(this.privateParamMonthList());
            },
            setModeForm: function (mode){
                this.runtime.mode = mode;
            },
	        emitCheckLunaInchisa: function (checkBoxControl){
		        this.runtime.post.idPk = checkBoxControl.getAttribute("idPk");

		        this.setPost({name: 'checkValue' }, checkBoxControl.checked);
		        this.setPost({name: 'control' }, checkBoxControl);          // only for rebuild control is no action

		        this.privateServerCheckMonth();
	        },
	        emitYesNoButtonInsert: function (yes){
		        if(yes == 1){
			        this.runtime.sendDataToServer = true;
			        this.privateServerInsertMonth();

		        }else{
			        this.runtime.sendDataToServer = false;

		        }
            },
            emitYesNoButton: function (yes) {
                if(yes == 1){

	                this.runtime.post.field.control = null;     // nu mai avem nevoie de control checkbox

                    this.runtime.sendDataToServer = true;
                    this.privateServerCheckMonth();
                }else{
                    this.runtime.sendDataToServer = false;

                    //refac bifa
	                if(this.runtime.post.field.checkValue){
		                this.runtime.post.field.control.checked = false;
	                } else {
		                this.runtime.post.field.control.checked = true;
	                }

	                this.runtime.post.field.control = null;     // nu mai avem nevoie de control checkbox
                }
            },
            setPost: function (component, value){
                this.runtime.post['field'][component.name] = value;
            },
	        setPostInsert: function (component, value){
		        this.runtime.postInsert['field'][component.name] = value;
	        },
            privateParamMonthList: function (){
	            return {'yearList': this.runtime.yearList};
            },
	        validateForm: function () {
		        let returnMessage = false;
		        let validateArray = [this.$refs[this.cfgtime.FIELD_YEAR.ref], this.$refs[this.cfgtime.FIELD_MONTH.ref]];

		        this.runtime.message = [];
		        this.$check.validateForm(validateArray);

		        if( this.runtime.message.length>0 ){
			        this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
			        this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.runtime.message));
			        returnMessage = true;
		        }
		        return returnMessage;
	        },
	        validateYear: function(){
		        let obj = this.cfgtime.FIELD_YEAR;
		        let value = parseInt(this.$refs[obj.ref].getValue());

		        if(!this.$check.intervalCheck(value, parseInt(obj.minLength), parseInt(obj.maxLength))){
			        this.runtime.message.push(this.$app.getFormMessageClass(obj.id, obj.caption,
				        'anul trebuie sa fie intre ' + obj.minLength + " si maxim " + obj.maxLength + " !"));
		        }
		        this.setPostInsert(obj, value);
            },
	        validateMonth: function(){
		        let obj = this.cfgtime.FIELD_MONTH;
		        let value = parseInt(this.$refs[obj.ref].getValue());

		        if(!this.$check.intervalCheck(value, parseInt(obj.minLength), parseInt(obj.maxLength))){
			        this.runtime.message.push(this.$app.getFormMessageClass(obj.id, obj.caption,
				        'luna trebuie sa fie in intervalul ' + obj.minLength + " - " + obj.maxLength + " !"));
		        }
		        this.setPostInsert(obj, value);
            },
	        cfgYearField: function(){
		        let cfg = this.$app.cfgInputField("year", 70, 40);
		        cfg.setValidate(2020,2050);
		        cfg.setValidateFunction(this.validateYear);
		        cfg.setCaption("Anul in lucru");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        },
	        cfgMonthField: function(){
		        let cfg = this.$app.cfgInputField("month", 70, 25);
		        cfg.setValidate(1,12);
		        cfg.setValidateFunction(this.validateMonth);
		        cfg.setCaption("Luna");
		        cfg.setMandatory(true);
		        cfg.setMaska("");
		        return cfg;
	        }
        },
        data () {
            return {
                captionButton: 'Adaug luna'
            }
        }
    }

</script>

<style scoped></style>
