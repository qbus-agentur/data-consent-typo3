upload:
	rsync -avz --delete -e ssh --exclude node_modules/ --exclude .git ./ qbusio@qbus.de:public_html/data-consent/
