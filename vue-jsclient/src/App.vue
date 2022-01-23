<template>
    <my-login v-if="!this.login" ref="refLogin" @loginWindows = "emitLogin"></my-login>
    <menu-main v-if="this.login" ref="refMenuLogout" @logoutMenuMain="emitMenuLogout" :key=this.engine.keyRender />
    <router-view/>
</template>

<script>
	import MenuMain from './components/app/MenuMain';
	import Login from '@/components/app/Login.vue';

	export default {
		components: {
			'menu-main': MenuMain,
			'my-login': Login
		},
        created() {
          this.URI  = this.$url.getUrl("loginCheck");
          this.checkLog();
        },
		methods: {
			emitLogin: function () {
				this.engine.keyRender ++;
				this.login = this.$refs.refLogin.isLogOn();
				this.$router.push('/');
			},
			emitMenuLogout: function () {
				if(this.$refs.refMenuLogout.isLogout()){
					this.engine.keyRender ++;
					this.login = false;
				}
			},
            checkLog: function (){
                this.axios.post(this.URI, this.post).then((response) => {
                        if(response.data.succes){
                            this.login = true;
                        }else{
                            this.login = false;
                        }
                }
                ).catch( (error) => {
                    this.login = false;
                })
            },
		},
		data() {
			return {
				login: false,
				engine: {keyRender: 1}
			}
		}
	}

</script>

<style lang="scss">
    @import "./scss/app.scss";
</style>
