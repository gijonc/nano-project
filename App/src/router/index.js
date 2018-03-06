import Vue from 'vue'
import vueResource from 'vue-resource'
import vueRouter from 'vue-router'
import bootstrap from 'bootstrap-vue'
import company_settings from '@/components/company_settings'


Vue.use(vueRouter)
Vue.use(vueResource)
Vue.use(bootstrap)

export default new vueRouter({

	mode: 'history',
	base: __dirname,
	routes: [
		{
			path: '/',
			component: company_settings
		},
	]
})
