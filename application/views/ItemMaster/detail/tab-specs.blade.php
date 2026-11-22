<!-- TAB 1: General Specifications, U/M, Physical Dimensions & Warehouse Controls -->
<div id="tab-specs" class="item-tab-panel p-space-lg flex flex-col gap-space-md">
    <!-- Card 1A: Core Identification & Classification -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-info text-[18px]">precision_manufacturing</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Core Identification &amp; Classification</span>
            </div>
            <span class="font-mono text-[11px] text-mute">AMECMFG.IIM</span>
        </div>
        <div class="p-space-md grid grid-cols-1 md:grid-cols-2 gap-x-space-lg">
            <table class="w-full text-xs">
                <tbody class="divide-y divide-base-200">
                    <tr>
                        <td class="py-2 text-mute w-1/2">Item / Purcode (<span class="font-mono">IPROD</span>)</td>
                        <td id="f-IPROD" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Record Status (<span class="font-mono">IID</span>)</td>
                        <td id="f-IID" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Drawing / Formula (<span class="font-mono">IDRAW</span>)</td>
                        <td id="f-IDRAW" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Drawing Ref (<span class="font-mono">IDRF</span>)</td>
                        <td id="f-IDRF" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Item Class (<span class="font-mono">ICLAS</span>)</td>
                        <td id="f-ICLAS" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Item Type (<span class="font-mono">IITYP</span>)</td>
                        <td id="f-IITYP" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">ABC Class / Type (<span class="font-mono">IABC / IABBT</span>)</td>
                        <td id="f-IABC" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-base-200">
                    <tr>
                        <td class="py-2 text-mute w-1/2">Commodity Code (<span class="font-mono">IMCOM</span>)</td>
                        <td id="f-IMCOM" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Group Tech Code (<span class="font-mono">IGTEC</span>)</td>
                        <td id="f-IGTEC" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Product Family (<span class="font-mono">IPFDV</span>)</td>
                        <td id="f-IPFDV" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Parent Item (<span class="font-mono">IPITM</span>)</td>
                        <td id="f-IPITM" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Substitute Item (<span class="font-mono">ISITM</span>)</td>
                        <td id="f-ISITM" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Business / Style (<span class="font-mono">IBUSY / ISTYL</span>)</td>
                        <td id="f-IBUSY" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Facility / Config (<span class="font-mono">IFCI / INCCFG</span>)</td>
                        <td id="f-IFCI" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-space-md pb-space-md pt-2 border-t border-base-200 grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            <div class="bg-base-200/50 border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Primary Description (<span class="font-mono">IDESC</span>)</div>
                <div id="f-IDESC" class="text-primary font-semibold mt-0.5">-</div>
            </div>
            <div class="bg-base-200/50 border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Extra Description (<span class="font-mono">IDSCE</span>)</div>
                <div id="f-IDSCE" class="text-primary mt-0.5">-</div>
            </div>
            <div class="bg-base-200/50 border border-base-200 p-2.5">
                <div class="text-[10px] font-bold uppercase text-mute">Ref Description (<span class="font-mono">IDSCR</span>)</div>
                <div id="f-IDSCR" class="text-primary mt-0.5">-</div>
            </div>
        </div>
    </div>

    <!-- Card 1B: Units of Measure, Physical Dimensions & Packaging -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-error text-[18px]">square_foot</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Units of Measure, Dimensions &amp; Packaging</span>
            </div>
            <span class="font-mono text-[11px] text-mute">U/M &amp; PHYSICAL</span>
        </div>
        <div class="p-space-md grid grid-cols-1 md:grid-cols-2 gap-x-space-lg">
            <table class="w-full text-xs">
                <tbody class="divide-y divide-base-200">
                    <tr>
                        <td class="py-2 text-mute w-1/2">Stocking U/M (<span class="font-mono">IUMS</span>)</td>
                        <td id="f-IUMS" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Purchasing U/M (<span class="font-mono">IUMP</span>)</td>
                        <td id="f-IUMP" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Purch U/M Conversion (<span class="font-mono">IUMCN</span>)</td>
                        <td id="f-IUMCN" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Sales / Report U/M (<span class="font-mono">IUMR</span>)</td>
                        <td id="f-IUMR" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Sales U/M Conversion (<span class="font-mono">IUMRC</span>)</td>
                        <td id="f-IUMRC" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Usage / Base / Alt U/M (<span class="font-mono">IMUSC/B/A</span>)</td>
                        <td id="f-IMUM-ALT" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-base-200">
                    <tr>
                        <td class="py-2 text-mute w-1/2">Unit Weight (<span class="font-mono">IWGHT</span>)</td>
                        <td id="f-IWGHT" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Base Weight (<span class="font-mono">IMBWT</span>)</td>
                        <td id="f-IMBWT" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Length × Width (<span class="font-mono">ICLNG × ICWID</span>)</td>
                        <td id="f-DIMS" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Standard Pack / Labels (<span class="font-mono">IPACK / ILABL</span>)</td>
                        <td id="f-IPACK" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Yield / Potency (<span class="font-mono">IMPOT</span>)</td>
                        <td id="f-IMPOT" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Material U/M Factor (<span class="font-mono">IUMAT</span>)</td>
                        <td id="f-IUMAT" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card 1C: Warehouse, Accounting & Control Flags -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[18px]">settings_applications</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Warehouse, Accounting &amp; System Control Flags</span>
            </div>
            <span class="font-mono text-[11px] text-mute">CONTROL MATRIX</span>
        </div>
        <div class="p-space-md grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">Warehouse (<span class="font-mono">IWHS</span>)</div>
                <div id="f-IWHS" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">Location (<span class="font-mono">ILOC</span>)</div>
                <div id="f-ILOC" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">G/L Account (<span class="font-mono">IGLNO</span>)</div>
                <div id="f-IGLNO" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">Tax / Disc (<span class="font-mono">TAXC1 / IDISC</span>)</div>
                <div id="f-TAXC1" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">Must Issue (<span class="font-mono">IMUST</span>)</div>
                <div id="f-IMUST" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">Active Flag (<span class="font-mono">ISACT</span>)</div>
                <div id="f-ISACT" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">MPS / Summary (<span class="font-mono">IMPSD / IMSUM</span>)</div>
                <div id="f-IMPSD" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5 bg-base-200/30">
                <div class="text-[10px] text-mute uppercase">Last Tx Date (<span class="font-mono">ILDTE</span>)</div>
                <div id="f-ILDTE" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
        </div>
    </div>
</div>
