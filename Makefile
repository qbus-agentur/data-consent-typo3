upload:
	rsync -avz --delete --copy-links -e ssh demo/ qbusio@qbus.de:public_html/data-consent/

build:
	npm run build
	npm run rollup
	npm run cleancss
	date +%s | tr -d '\n' > demo/buildtime

publish:
	npm run rollup
	npm publish --access public
