//SMILES, Inchi Regex , by lo sauer - lsauer.com
//Here's a PREG version for SMILES validation (JavaScript) beyond a length of 5:
var x = "OC[C@@H](O1)[C@@H](O)[C@H](O)[C@@H]2[C@@H]1c3c(O)c(OC)c(O)cc3C(=O)O2"

x.trim().match(/^([^J][a-z0-9@+\-\[\]\(\)\\\/%=#$]{6,})$/ig)[0]
>"OC[C@@H](O1)[C@@H](O)[C@H](O)[C@@H]2[C@@H]1c3c(O)c(OC)c(O)cc3C(=O)O2"

//for the most frequent organic molecules
x.trim().match(/^([^J][0-9BCOHNSOPrIFla@+\-\[\]\(\)\\\/%=#$]{6,})$/ig)

//generic Perl RegEx:
/^([^J][A-Za-z0-9@+\-\[\]\(\)\\\/%=#$]+)$/

//Note: The only letter not appearing on the Periodic Table is the letter "J"
//Annotated
x.trim().match(/^([^J][0-9BCOHNSOPrIFla@+\-\[\]\(\)\\\/%=#$]{6,})$/ig)

//if you need a carbon count:
x.toLowerCase().split('').map(function(v,k){return +'c'==v;})
>[false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false,
  false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, 
  false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, 
  false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, false, 
  false, false, false, false]
x.toLowerCase().split('').map(function(v,k){return 'c'==v|0;})
>[0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1,
  0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0]
if(!Array.prototype.hasOwnProperty('sum'))
{
    Array.prototype.sum = function (){return this.reduce(function(a,b){return a+b})}
}

x.toLowerCase().split('').map(function(v,k){return 'c'==v|0;}).sum()
>14

Array.prototype.atomCount = function(t){ return this.map(function(v,k){return t==v|0;}).reduce(function(a,b){return a+b}) };