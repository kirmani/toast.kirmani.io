<head>
	<title>toast@kirmani</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
    <link href="css/jquery.terminal.css" rel="stylesheet"/>
	
	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="js/jquery.mousewheel-min.js"></script>
    <script src="js/jquery.terminal-0.7.12.js"></script>
    <script src="js/code.js"></script>
    
</head>
<script>
untoasted = 1;
toasted = 2;
burned = 3;

function Toaster() {
	this.slots = [0,0];
	this.put = function(bread) {
		if (!this.slots[0]) {
			this.slots[0] = bread;
			return 0;	
		} else if (!this.slots[1]) {
			this.slots[1] = bread;
			return 1;
		}
		return -1;
	};
	this.get = function(index) {
		ret = this.slots[index];
		this.slots[index] = 0;
		return ret;
	};
	this.heat = function() {
		for (index in this.slots) {
			bread = this.slots[index];
			if (bread == untoasted) {
				this.slots[index] = toasted;	
			} else if (bread == toasted) {
				this.slots[index] = burned;	
			}
		}
	};
}

t = new Toaster();

jQuery(function($, undefined) {
    $('#term').terminal(function(command, term) {
		command = command.toLowerCase();
		switch (command)
		{
			case "help": 
				term.echo("    put");
				term.echo("    get");
				term.echo("    heat");
				break;
			case "heat":
				term.echo("heating...");
				t.heat();
				break;
			case "put":
				slot = t.put(untoasted);
				if (slot == -1) {
					term.echo("no room in toaster");
				} else {
					term.echo("put untoasted bread in slot " + slot);
				}
				break;
			case "get":
				for (slot = 0; slot < 2; slot++) {
					got = t.get(slot);
					if (got == untoasted) {
						term.echo("untoasted slice got from slot " + slot);
					} else if (got == toasted) {
						term.echo("toasted slice got from slot " + slot);
					} else if (got == burned) {
						term.echo("burned slice got from slot " + slot);
					}
				}
				break;
			case "contact":
				term.echo("    Email:    sean@kirmani.io");
				term.echo("    LinkedIn: sekrim");
				term.echo("    Twitter:  @AH_Sean");
				term.echo("    Facebook: SekrimK");
				term.echo("    Github:   Sekrim");
				term.echo("    Mobile:   (702) 497-3227");
				break;
			case "":
				break;
			default:
				term.echo("valid commands are put, get, and heat");
				break;
		} 
    }, {
        greetings: 'This is a toaster. Valid commands are put, get, and heat.\nThanks to William Morriss for the original idea.',
        name: 'js_demo',
        prompt: 'toaster@kirmani:/$ ',
		keypress: function(e) {
                if (e.which == 96) {
                    return false;
                }
            }
		});
	});
</script>
<div id="term" class="terminal" style="height: 100%;"></div>
