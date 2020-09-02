upload:
	rsync -avz --delete -e ssh --exclude node_modules/ --exclude .git ./ qbusio@qbus.de:public_html/data-consent/

build:
	npm run build
	npm run rollup
	npm run cleancss
	date +%s | tr -d '\n' > buildtime

publish:
	npm run rollup
	npm publish --access public
