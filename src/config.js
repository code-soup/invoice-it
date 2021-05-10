module.exports = {
    entry: {
        main: ["scripts/main.js", "styles/main.scss"],		// root javascript and style files - frontend
		print: ["styles/print.scss"],						// style file for print stylesheet - frontend
        invoice: ["scripts/util/invoice.js"],				// javascript file invoice post-type - backend
        admin: ["scripts/admin.js", "styles/admin.scss"],	// root javascript and style files - backend
        ajax: ["scripts/ajax.js"],	// ajax - backend
    },
    openBrowserOnWatch: false,								// open browser with devUrl url on watch
    showErrorsInBrowser: true,								// show webpack errors on frontent
    useSSLinDev: false,										// use https: in devUrl
    publicPath: "/wp-content/plugins/wppb",					// path to plugin
    devUrl: "http://mylocal.domain",						// localhost or custom domain name
    proxyUrl: "http://localhost",							// proxyUrl
    proxyPort: 3000,										// port to use on "watch"
    watch: ["includes/**/*.php"],							// folders / files to include in live reload
};