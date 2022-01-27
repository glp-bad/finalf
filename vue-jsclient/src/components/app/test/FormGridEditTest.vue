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


    <div class="ff-form-modal" ref="modalRef">

        <div :class=formClass.container :ref=CONTAINER_REF :id=cfgForm.id >
            <div :class=formClass.header ref="headerRef" >
                <span class="caption" ref="captionRef"></span>
                <div class="closeButton" @click="closeForm"><font-awesome-icon :icon="cfgForm.closeIcon" /></div>
            </div>

            <div :class=formClass.content ref="contentRef">
                <form>
                    <table class="ff-form-table">
                        <tr>
                            <td class="label bold">
                                <label :for=NUME.id>{{NUME.caption}}</label></td>
                            <td class="control">
                                <test-field
                                        :id=NUME.id
                                        :ref=NUME.ref
                                        maska=""
                                        :validate=NUME.validate
                                        :minlength = NUME.minLength
                                        :maxlength = NUME.maxLength
                                        :size = NUME.sizeField
                                ></test-field>

                            </td>

                            <td class="label bold">
                                <label :for=DESCRIERE.id>{{DESCRIERE.caption}}</label></td>
                            <td class="control">
                                <test-field
                                        :id=DESCRIERE.id
                                        :ref=DESCRIERE.ref
                                        maska=""
                                        :validate=DESCRIERE.validate
                                        :minlength = DESCRIERE.minLength
                                        :maxlength = DESCRIERE.maxLength
                                        :size = DESCRIERE.sizeField
                                ></test-field>
                            </td>

                        </tr>
                    </table>
                </form>
            </div>

            <div :class=formClass.button >
                <div :class=formClass.buttonPozition  >
                    <button-send @click="sendData(this.$constGrid.SQL_UPDATE)">Update data</button-send>
                </div>

                <div :class=formClass.buttonPozition  >
                    <button-send @click="sendData(this.$constGrid.SQL_DELETE)">Delete data</button-send>
                </div>
            </div>

            <div :class=formClass.bottomLine ></div>

        </div>

    </div>

</template>

<script>

    import InputField from '../../base/InputField.vue';
    import Button from '../../base/Button.vue';
    import AlertWindow from '../../base/AlertWindow.vue';
    import CheckBox from '../../base/CheckBox.vue';
    // import DropDownSimple from '../../base/DropDownSimple.vue'

    export default {
		components: {
			'test-field': InputField,
			'check-box': CheckBox,
			'button-send': Button,
			'validate-window': AlertWindow
            // 'lista-numere': DropDownSimple
		},
		name: "grid-edit-test",
		created() {
			    this.CONTAINER_REF = 'containerRef';
			    this.NUME       = this.cfgNume();
				this.DESCRIERE    = this.cfgDescriere();
                this.EMIT_UPDATEGRID = 'emitUpdateGrid';
		},
        mounted () {
	        this.configForm();
        },
	    emits: ['emitUpdateGrid'],
		methods: {
			closeForm: function () {
				// this.$refs[this.CONTAINER_REF].remove();
				this.$refs[this.CONTAINER_REF].style.display = "none";
				this.$refs.modalRef.style.display = "none";
			},

			showForm: function (parentDiv, dataGridSource) {

				this.$refs.modalRef.style.display = "inline-block";
				this.$refs[this.CONTAINER_REF].style.display = "table";
				if(!this.$check.isUndef(parentDiv)){
					this.$vanilla.centerDiv(parentDiv, this.$refs[this.CONTAINER_REF]);
                }

                this.setPostData(dataGridSource, null)

			},
			setPostData: function (dataValue, actionType) {

				if(this.$check.isUndef(dataValue)){
					this.post.name        = this.$refs[this.NUME.ref].getValue();
					this.post.description = this.$refs[this.DESCRIERE.ref].getValue();
					this.post.actionType  = actionType;
                }
				else{
					this.post.id          = dataValue.idPk;
					this.post.name        = dataValue.name;
					this.post.description = dataValue.description;
					this.post.actionType  = actionType;

					this.$refs[this.NUME.ref].setValue(this.post.name);
					this.$refs[this.DESCRIERE.ref].setValue(this.post.description);
                }

            },

    		cfgNume: function () {
				let cfg = this.$app.cfgTextFIeld();
				    cfg.setIdAndRef("nume");
					cfg.minLength   = 3;
					cfg.maxLength   = 10;
					cfg.validate    = this.validateNume;
					cfg.maska       = "";
					cfg.caption     = "Nume";
					cfg.mandatory   = false;
				    cfg.sizeField  = 10;

                return cfg;
			},
			cfgDescriere: function () {

				let cfg = this.$app.cfgTextFIeld();
				cfg.setIdAndRef("descriere");
				cfg.minLength   = 4;
				cfg.maxLength   = 200;
				cfg.validate    = this.validateDescriere;
				cfg.maska       = "";
				cfg.caption     = "Descriere";
				cfg.mandatory   = false;
				cfg.sizeField  = 30;

				return cfg;
			},
			configForm: function () {
				this.cfgForm.id = '777TEST'; // this.$uuid.v1();
    			this.cfgForm.closeIcon = ['fas', 'times'];
                    // this.$refs.containerRef.style.width = '900px';
                    // this.$refs.containerRef.style.height = '120px';
                    // this.$refs.contentRef.style.width = '300px';
                    // this.$refs.contentRef.style.height = '300px';
				this.$refs.captionRef.innerHTML="Introducere date de test";
				this.$vanilla.dragDiv(this.$refs.containerRef, this.$refs.headerRef);


				//console.log(document.body.firstElementChild);
				//console.log(this.$root);
				//console.log(this.$root.$children[0].$el);
				//console.log(this.$refs);

				/*
				document.getElementById('app').appendChild(
					//document.getElementById('MacGuffin')
					this.$refs.validateWindowRef
				);
				*/

				// this.$mount(this.$refs.validateWindowRef);
				//this.$root.$el.append(this.$refs.validateWindowRef);
				/*


				let div = document.body.firstElementChild;

				div.appendChild(
					//document.getElementById('MacGuffin')
					this.$refs.validateWindowRef
				);
                */



			},
			emitYesNoButton: function (yes) {
                if(yes == 1){
	                this.deleteYes = true;
	                this.sendData(this.$constGrid.SQL_DELETE);

                }else{
	                this.deleteYes = false;

                }

			},
            sendData: function(actionType){
                this.validateForm();

                if(this.messageForm.length > 0 && actionType != this.$constGrid.SQL_DELETE){
	                this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
	                this.$refs.validateWindowRef.setMessage(this.$app.getHtmlFormatMessage(this.messageForm));
	                this.$refs.validateWindowRef.show();

	                return false;
                }

                    if(actionType == this.$constGrid.SQL_DELETE && !this.deleteYes) {
                          // ask operation
                          this.$refs.refYesNo.setCaption("Delete");
                          this.$refs.refYesNo.setMessage("Datele sterse nu mai pot fi recuperate!");
                          this.$refs.refYesNo.show();
                    }else{
                	    // orice alt caz ce nu necesita confirmare
	                    this.deleteYes = true;
                    }


	                if(this.deleteYes){
		                this.deleteYes = false;

		                let uri = this.$url.getUrl("gridDataTestUpdate");

		                this.setPostData(null, actionType);

		                this.axios
			                .post(uri, this.post)
			                .then(response => {
				                if (response.data.succes) {
					                this.$emit(this.EMIT_UPDATEGRID, actionType, this.post);
					                this.closeForm();
					                this.$refs.infoWindowRef.setCaption("Succes");
					                this.$refs.infoWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					                this.$refs.infoWindowRef.show();
				                }
				                else {
					                this.$refs.validateWindowRef.setCaption("Datele nu pot fi inregistrate");
					                this.$refs.validateWindowRef.setMessage(this.$appServer.getHtmlSqlFormatMessage(response.data));
					                this.$refs.validateWindowRef.show();
				                }
			                })
			                .catch(error => {
				                this.$refs.redWindowRef.setCaption("Probleme ... ");
				                this.$refs.redWindowRef.setMessage(error);
				                this.$refs.redWindowRef.show();
			                });

	                }

            },
            validateForm: function () {
	            this.messageForm = [];
                this.$check.validateForm(this.$refs);
            },
            validateNume: function () {
				if(!this.$check.lenghtMinMax(this.$refs[this.NUME.ref].getValue(), this.NUME.minLength, this.NUME.maxLength)){
					this.messageForm.push(this.$app.getFormMessageClass(this.NUME.id, this.NUME.caption,
                                    'trebuie sa aiba minim ' + this.NUME.minLength + " si maxim " + this.NUME.maxLength + " caractere"));
                }

            },
			validateDescriere: function () {

				let obj = this.DESCRIERE;

				if(!this.$check.lenghtMinMax(this.$refs[obj.ref].getValue(), obj.minLength, obj.maxLength)){
					this.messageForm.push(this.$app.getFormMessageClass(obj.id, obj.caption,
						'trebuie sa aiba minim ' + obj.minLength + " si maxim " + obj.maxLength + " caractere"));
				}
			}

		},
		data () {
			return {
				formClass: this.$css.getCss("form"),
                messageForm: [],
				post:       {},
				cfgForm:    {id: null, closeIcon: ['fas', 'times']},
                deleteYes: false

            }
		}
	}

</script>

<style scoped></style>
