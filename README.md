# Meanbee_CacheViewer

Meanbee_CacheViewer provides interfaces for inspecting Magento cache.

## Usage

### Analysing Block Cache

Enabled with a configuration setting in `System` &raquo; `Configuration` &raquo; `Cache Viewer`, the frontend overlay indicates
which blocks were generated (red) and which were retrieved from the block_html cache (green) as well as showing the
last modified time for each block and the total time taken to dispatch the request.

This will become enabled for the frontend and the admin area and is controlled by the control bar added at the bottom of the viewport.

![Cache Viewer frontend overlay](http://f.cl.ly/items/0F2D0s3c0I34210z1e3S/cache-viewer-frontend.png)

![Cache Viewer frontend overlay with hints disabled](http://f.cl.ly/items/0N2t3R0R2a232R3w191L/cache-viewer-frontend-nohints.png)

### View Cache Contents

The backend interface, found in `System` &raquo; `Cache Management` &raquo; `View Cache Contents` in the Administration area, allows
viewing, inspecting or deleting all of the cache entries present in the Magento cache.

![Cache Viewer](http://up.nicksays.co.uk/image/0C1W29041R3y/release_0.1.0.png)

## License

	Meanbee_CacheViewer, a Magento extension for inspecting cache contents.
	
	Copyright (C) 2013, Meanbee Limited.
	
	This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.
