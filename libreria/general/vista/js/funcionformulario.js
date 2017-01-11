/* 
 *  FuidXel is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  
 *  FuidXel is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  
 *  You should have received a copy of the GNU General Public License
 *  along with FuidXel.  If not, see <http://www.gnu.org/licenses/>.
 */

function muestraCalendario(concalendario,nombre){
    var cal = new Calendar.setup({
				 inputField     :    nombre,   // id of the input field
				 button         :    "lanzador" + concalendario +"",  // What will trigger the popup of the calendar
				//button	: \"$nombre\",
				 ifFormat       :    "%d/%m/%Y"       // format of the input field: Mar 18, 2005
		});
}

