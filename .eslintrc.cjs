module.exports = {
	env: {
		browser: true,
		es2021: true,
	},
	extends: ["eslint:recommended", "plugin:vue/vue3-recommended"],
	overrides: [
		{
			env: {
				node: true,
			},
			files: [".eslintrc.{js,cjs}"],
			parserOptions: {
				sourceType: "script",
			},
		},
	],
	parserOptions: {
		ecmaVersion: "latest",
		sourceType: "module",
	},
	plugins: ["vue"],
	ignorePatterns: ["plugins/"],
	rules: {
		"vue/multi-word-component-names": "off",
		"vue/html-indent": "off",
		"vue/html-self-closing": "off",
		"no-undef": "off",
		"vue/singleline-html-element-content-newline": "off",
		"vue/html-closing-bracket-newline": "off",
		"no-mixed-spaces-and-tabs": "off",
		"vue/max-attributes-per-line": [
			"error",
			{
				singleline: {
					max: 4,
				},
			},
		],
	},
};
