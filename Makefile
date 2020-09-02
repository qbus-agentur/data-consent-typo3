upload:
	rsync -avz --delete -e ssh --exclude node_modules/ --exclude .git ./ qbusio@qbus.de:public_html/data-consent/

build:
	npm run build
	npm run rollup
	cp node_modules/es6-promise/dist/es6-promise.auto.min.js Resources/Public/JavaScript/
	npm run cleancss
	date +%s | tr -d '\n' > buildtime

publish:
	npm run rollup
	npm publish --access public
