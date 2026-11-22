<script setup>
defineProps({
	diagram: {
		type: String,
		required: true,
		validator: (v) => ["system-flow", "data-lineage", "scm-user-flow"].includes(v),
	},
});
</script>

<template>
	<div class="vp-diagram-card">
		<!-- 1. End-to-End Vendor Lifecycle & Approval Flowchart -->
		<svg
			v-if="diagram === 'system-flow'"
			viewBox="0 0 960 440"
			class="vp-diagram-svg"
			role="img"
			aria-label="Vendor Management End-to-End System & Approval Flowchart"
		>
			<defs>
				<marker id="arrow-main" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
					<path d="M 0 1 L 10 5 L 0 9 z" class="svg-arrow-fill" />
				</marker>
				<marker id="arrow-red" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
					<path d="M 0 1 L 10 5 L 0 9 z" fill="#e60012" />
				</marker>
				<marker id="arrow-green" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
					<path d="M 0 1 L 10 5 L 0 9 z" fill="#16a34a" />
				</marker>
			</defs>

			<!-- Swimlane Backgrounds -->
			<rect x="12" y="12" width="936" height="122" rx="6" class="lane-bg" />
			<text x="26" y="34" class="lane-label">1. ENTRY &amp; AUTHENTICATION (@amec/webasset)</text>

			<rect x="12" y="146" width="936" height="134" rx="6" class="lane-bg" />
			<text x="26" y="168" class="lane-label">2. VENDOR REGISTRATION / COVER SHEET APPROVAL FLOW (PRO-QP-A-020)</text>

			<rect x="12" y="292" width="936" height="136" rx="6" class="lane-bg" />
			<text x="26" y="314" class="lane-label">3. MASTER REGISTRY &amp; DOWNSTREAM SYSTEM SYNC</text>

			<!-- Lane 1 Nodes -->
			<rect x="30" y="50" width="165" height="64" rx="6" class="node-box node-neutral" />
			<text x="112" y="76" text-anchor="middle" class="node-title">User Login</text>
			<text x="112" y="96" text-anchor="middle" class="node-sub">Cookie + IndexedDB</text>

			<rect x="240" y="50" width="195" height="64" rx="6" class="node-box node-blue" />
			<text x="337" y="76" text-anchor="middle" class="node-title">Vendor Directory</text>
			<text x="337" y="96" text-anchor="middle" class="node-sub">/vendors → search API</text>

			<rect x="485" y="50" width="205" height="64" rx="6" class="node-box node-blue" />
			<text x="587" y="76" text-anchor="middle" class="node-title">Vendor Detail (5 Tabs)</text>
			<text x="587" y="96" text-anchor="middle" class="node-sub">Read-Only + Group Link</text>

			<rect x="740" y="50" width="190" height="64" rx="6" class="node-box node-amber" />
			<text x="835" y="76" text-anchor="middle" class="node-title">Request Change</text>
			<text x="835" y="96" text-anchor="middle" class="node-sub">Create / Cover Sheet (U)</text>

			<!-- Lane 1 Arrows -->
			<line x1="195" y1="82" x2="238" y2="82" class="svg-line" marker-end="url(#arrow-main)" />
			<line x1="435" y1="82" x2="483" y2="82" class="svg-line" marker-end="url(#arrow-main)" />
			<line x1="690" y1="82" x2="738" y2="82" class="svg-line" marker-end="url(#arrow-main)" />

			<!-- Down arrow from Request Change to Lane 2 -->
			<path d="M 835 114 L 835 135 L 112 135 L 112 184" fill="none" class="svg-line" marker-end="url(#arrow-main)" />

			<!-- Lane 2 Nodes (Approval Chain) -->
			<rect x="30" y="186" width="165" height="68" rx="6" class="node-box node-amber" />
			<text x="112" y="213" text-anchor="middle" class="node-title">Step 1: Buyer</text>
			<text x="112" y="233" text-anchor="middle" class="node-sub">Submit Form (Running)</text>

			<rect x="240" y="186" width="165" height="68" rx="6" class="node-box node-amber" />
			<text x="322" y="213" text-anchor="middle" class="node-title">Step 2: SEM</text>
			<text x="322" y="233" text-anchor="middle" class="node-sub">Verify Tax / Docs</text>

			<rect x="450" y="186" width="165" height="68" rx="6" class="node-box node-amber" />
			<text x="532" y="213" text-anchor="middle" class="node-title">Step 3: DEM</text>
			<text x="532" y="233" text-anchor="middle" class="node-sub">Final Approval</text>

			<!-- Decision Diamond -->
			<polygon points="710,180 778,220 710,260 642,220" class="node-decision" />
			<text x="710" y="217" text-anchor="middle" class="node-title">Approved?</text>
			<text x="710" y="233" text-anchor="middle" class="node-sub">FRM_STATUS</text>

			<rect x="812" y="188" width="118" height="64" rx="6" class="node-box node-red" />
			<text x="871" y="215" text-anchor="middle" class="node-title">Reject (3)</text>
			<text x="871" y="235" text-anchor="middle" class="node-sub">Return to Buyer</text>

			<!-- Lane 2 Arrows -->
			<line x1="195" y1="220" x2="238" y2="220" class="svg-line" marker-end="url(#arrow-main)" />
			<line x1="405" y1="220" x2="448" y2="220" class="svg-line" marker-end="url(#arrow-main)" />
			<line x1="615" y1="220" x2="640" y2="220" class="svg-line" marker-end="url(#arrow-main)" />
			<line x1="778" y1="220" x2="810" y2="220" stroke="#e60012" stroke-width="2" marker-end="url(#arrow-red)" />
			<text x="794" y="211" text-anchor="middle" class="edge-label-red">No</text>

			<!-- Approve (2) Down to Lane 3 -->
			<path d="M 710 260 L 710 282 L 160 282 L 160 332" fill="none" stroke="#16a34a" stroke-width="2" marker-end="url(#arrow-green)" />
			<text x="724" y="276" class="edge-label-green">Yes (Approve = 2)</text>

			<!-- Lane 3 Nodes (Sync) -->
			<rect x="40" y="334" width="240" height="72" rx="6" class="node-box node-green" />
			<text x="160" y="362" text-anchor="middle" class="node-title">Oracle DB (PURSYS)</text>
			<text x="160" y="382" text-anchor="middle" class="node-sub">Update PUR_VENDORS &amp; History</text>

			<rect x="355" y="334" width="245" height="72" rx="6" class="node-box node-blue" />
			<text x="477" y="362" text-anchor="middle" class="node-title">AS400 ERP Sync</text>
			<text x="477" y="382" text-anchor="middle" class="node-sub">5-Digit Vendor Code (AS400: SYNCED)</text>

			<rect x="675" y="334" width="250" height="72" rx="6" class="node-box node-blue" />
			<text x="800" y="362" text-anchor="middle" class="node-title">E-SCM / EDI Portal</text>
			<text x="800" y="382" text-anchor="middle" class="node-sub">PO / ASN / CAR / Drawings Ready</text>

			<line x1="280" y1="370" x2="353" y2="370" stroke="#16a34a" stroke-width="2" marker-end="url(#arrow-green)" />
			<line x1="600" y1="370" x2="673" y2="370" stroke="#16a34a" stroke-width="2" marker-end="url(#arrow-green)" />
		</svg>

		<!-- 2. Data Linkage & ER Architecture Diagram -->
		<svg
			v-else-if="diagram === 'data-lineage'"
			viewBox="0 0 960 470"
			class="vp-diagram-svg"
			role="img"
			aria-label="Vendor Data Linkage and Database ER Diagram"
		>
			<defs>
				<marker id="arrow-er" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
					<path d="M 0 1 L 10 5 L 0 9 z" class="svg-arrow-fill" />
				</marker>
				<marker id="arrow-blue" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
					<path d="M 0 1 L 10 5 L 0 9 z" fill="#2563eb" />
				</marker>
			</defs>

			<!-- Column Headers -->
			<text x="115" y="26" text-anchor="middle" class="col-header">FRONTEND (BLADE + JS)</text>
			<text x="360" y="26" text-anchor="middle" class="col-header">REST API (APP_API)</text>
			<text x="710" y="26" text-anchor="middle" class="col-header">ORACLE DATABASE (SCHEMA: PURSYS)</text>

			<!-- Frontend Boxes -->
			<rect x="20" y="46" width="190" height="72" rx="6" class="node-box node-blue" />
			<text x="115" y="72" text-anchor="middle" class="node-title">vendors/index</text>
			<text x="115" y="90" text-anchor="middle" class="node-sub">vendor/index.js</text>
			<text x="115" y="106" text-anchor="middle" class="node-sub">KPI + DataTable + Export</text>

			<rect x="20" y="140" width="190" height="84" rx="6" class="node-box node-blue" />
			<text x="115" y="166" text-anchor="middle" class="node-title">vendors/detail/{id}</text>
			<text x="115" y="184" text-anchor="middle" class="node-sub">vendor/detail.js</text>
			<text x="115" y="200" text-anchor="middle" class="node-sub">5 Tabs + Group + Diff</text>

			<rect x="20" y="246" width="190" height="72" rx="6" class="node-box node-amber" />
			<text x="115" y="272" text-anchor="middle" class="node-title">vendors/approval</text>
			<text x="115" y="290" text-anchor="middle" class="node-sub">approval.js / frmapv.js</text>
			<text x="115" y="306" text-anchor="middle" class="node-sub">Cover Sheet Flow</text>

			<rect x="20" y="340" width="190" height="72" rx="6" class="node-box node-green" />
			<text x="115" y="366" text-anchor="middle" class="node-title">vendors/users</text>
			<text x="115" y="384" text-anchor="middle" class="node-sub">vendor/users.js</text>
			<text x="115" y="400" text-anchor="middle" class="node-sub">Portal RBAC &amp; Accounts</text>

			<!-- API Service Boxes -->
			<rect x="255" y="54" width="210" height="58" rx="6" class="node-box node-neutral" />
			<text x="360" y="78" text-anchor="middle" class="node-title">/pursys/vendors/search</text>
			<text x="360" y="96" text-anchor="middle" class="node-sub">POST • Directory List</text>

			<rect x="255" y="132" width="210" height="96" rx="6" class="node-box node-neutral" />
			<text x="360" y="156" text-anchor="middle" class="node-title">/pursys/vendors/detail</text>
			<text x="360" y="174" text-anchor="middle" class="node-sub">/history • /evaluation</text>
			<text x="360" y="192" text-anchor="middle" class="node-sub">/groups/by-code • /link</text>
			<text x="360" y="210" text-anchor="middle" class="node-sub">/set-primary • /unlink</text>

			<rect x="255" y="250" width="210" height="64" rx="6" class="node-box node-neutral" />
			<text x="360" y="276" text-anchor="middle" class="node-title">/vendorApprovals</text>
			<text x="360" y="294" text-anchor="middle" class="node-sub">GET (MOCK_API → APP_API)</text>

			<rect x="255" y="340" width="210" height="72" rx="6" class="node-box node-neutral" />
			<text x="360" y="366" text-anchor="middle" class="node-title">/pursys/vendors/users/*</text>
			<text x="360" y="384" text-anchor="middle" class="node-sub">POST /search • POST /</text>
			<text x="360" y="400" text-anchor="middle" class="node-sub">PUT /{id} • /reset-password</text>

			<!-- Frontend -> API Arrows -->
			<line x1="210" y1="82" x2="253" y2="82" class="svg-line" marker-end="url(#arrow-er)" />
			<line x1="210" y1="180" x2="253" y2="180" class="svg-line" marker-end="url(#arrow-er)" />
			<line x1="210" y1="282" x2="253" y2="282" class="svg-line" marker-end="url(#arrow-er)" />
			<line x1="210" y1="376" x2="253" y2="376" class="svg-line" marker-end="url(#arrow-er)" />

			<!-- Database Entity Boxes -->
			<!-- Master PUR_VENDORS -->
			<rect x="520" y="48" width="210" height="106" rx="6" class="db-box db-primary" />
			<rect x="520" y="48" width="210" height="28" rx="6" class="db-header-red" />
			<text x="625" y="67" text-anchor="middle" class="db-title">PUR_VENDORS (Master)</text>
			<text x="532" y="94" class="db-field">PK  VND_ID (IDENTITY)</text>
			<text x="532" y="112" class="db-field">    VND_NAME, VND_TNAME</text>
			<text x="532" y="130" class="db-field">    VND_TYPE (1-8), VND_STATUS</text>
			<text x="532" y="146" class="db-field">    BANKNAME, ACCNUMBER</text>

			<!-- PUR_VENDORS_CODE -->
			<rect x="758" y="48" width="186" height="92" rx="6" class="db-box" />
			<rect x="758" y="48" width="186" height="26" rx="6" class="db-header-blue" />
			<text x="851" y="66" text-anchor="middle" class="db-title">PUR_VENDORS_CODE</text>
			<text x="768" y="90" class="db-field">PK  CODE_ID</text>
			<text x="768" y="107" class="db-field">FK  VENDOR_ID → VND_ID</text>
			<text x="768" y="124" class="db-field">    CODE_NUM (5-Digit AS400)</text>
			<text x="768" y="136" class="db-field">    CODE_CURRENCY, CODE_PAY</text>

			<!-- PUR_VENDORS_ADDRESS -->
			<rect x="520" y="186" width="205" height="88" rx="6" class="db-box" />
			<rect x="520" y="186" width="205" height="26" rx="6" class="db-header-blue" />
			<text x="622" y="204" text-anchor="middle" class="db-title">PUR_VENDORS_ADDRESS</text>
			<text x="530" y="228" class="db-field">PK  ADDR_ID</text>
			<text x="530" y="245" class="db-field">FK  VENDOR_ID → VND_ID</text>
			<text x="530" y="262" class="db-field">    ADDR_TYPE, LINE1-3, CITY</text>

			<!-- PUR_VENDORS_ATTFILE -->
			<rect x="758" y="186" width="186" height="88" rx="6" class="db-box" />
			<rect x="758" y="186" width="186" height="26" rx="6" class="db-header-blue" />
			<text x="851" y="204" text-anchor="middle" class="db-title">PUR_VENDORS_ATTFILE</text>
			<text x="768" y="228" class="db-field">PK  FILE_ID</text>
			<text x="768" y="245" class="db-field">FK  VENDOR_ID → VND_ID</text>
			<text x="768" y="262" class="db-field">    FILE_NAME (NAS), UFILE</text>

			<!-- Group / Evaluation / History -->
			<rect x="520" y="302" width="205" height="68" rx="6" class="db-box" />
			<rect x="520" y="302" width="205" height="24" rx="6" class="db-header-slate" />
			<text x="622" y="319" text-anchor="middle" class="db-title">GROUPS / EVA / HISTORY</text>
			<text x="530" y="342" class="db-field">VGRP-xxxxx (Multi-Currency)</text>
			<text x="530" y="358" class="db-field">Revision Diff &amp; EVA Grade</text>

			<!-- E-SCM Users -->
			<rect x="520" y="388" width="205" height="68" rx="6" class="db-box" />
			<rect x="520" y="388" width="205" height="24" rx="6" class="db-header-green" />
			<text x="622" y="405" text-anchor="middle" class="db-title">E-SCM USERS (AMEC-EDI)</text>
			<text x="530" y="428" class="db-field">FK  VND_CODE → CODE_NUM</text>
			<text x="530" y="444" class="db-field">    USER_ROLE, USER_STATUS</text>

			<!-- External AS400 Box -->
			<rect x="758" y="302" width="186" height="154" rx="6" class="db-box" />
			<rect x="758" y="302" width="186" height="26" rx="6" class="db-header-slate" />
			<text x="851" y="320" text-anchor="middle" class="db-title">EXTERNAL INTEGRATIONS</text>
			<text x="768" y="346" class="db-field">• AS400 ERP (Master Sync)</text>
			<text x="768" y="366" class="db-field">• NAS Storage (FILE_ATTACH)</text>
			<text x="768" y="386" class="db-field">• AMEC Webflow (Auth/Mail)</text>
			<text x="768" y="406" class="db-field">• E-SCM Supplier Portal</text>
			<text x="768" y="432" class="db-field">Key: VENDCODE (5-Digit)</text>

			<!-- API -> DB Connections -->
			<line x1="465" y1="82" x2="518" y2="82" stroke="#2563eb" stroke-width="1.8" marker-end="url(#arrow-blue)" />
			<path d="M 465 180 L 492 180 L 492 115 L 518 115" fill="none" stroke="#2563eb" stroke-width="1.8" marker-end="url(#arrow-blue)" />
			<path d="M 465 180 L 492 180 L 492 230 L 518 230" fill="none" stroke="#2563eb" stroke-width="1.8" marker-end="url(#arrow-blue)" />
			<path d="M 465 180 L 492 180 L 492 336 L 518 336" fill="none" stroke="#2563eb" stroke-width="1.8" marker-end="url(#arrow-blue)" />
			<path d="M 465 376 L 492 376 L 492 422 L 518 422" fill="none" stroke="#2563eb" stroke-width="1.8" marker-end="url(#arrow-blue)" />

			<!-- ER Relations between Oracle Tables -->
			<line x1="730" y1="92" x2="756" y2="92" class="svg-line" marker-end="url(#arrow-er)" />
			<text x="743" y="85" text-anchor="middle" class="er-card">1:N</text>

			<line x1="622" y1="154" x2="622" y2="184" class="svg-line" marker-end="url(#arrow-er)" />
			<text x="636" y="173" class="er-card">1:N</text>

			<path d="M 730 132 L 744 132 L 744 228 L 756 228" fill="none" class="svg-line" marker-end="url(#arrow-er)" />
			<text x="744" y="178" text-anchor="middle" class="er-card">1:N</text>
		</svg>

		<!-- 3. E-SCM User Provisioning & RBAC Governance Flow -->
		<svg
			v-else-if="diagram === 'scm-user-flow'"
			viewBox="0 0 960 215"
			class="vp-diagram-svg"
			role="img"
			aria-label="E-SCM User Provisioning and Access Control Flow"
		>
			<defs>
				<marker id="arrow-scm" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
					<path d="M 0 1 L 10 5 L 0 9 z" class="svg-arrow-fill" />
				</marker>
			</defs>

			<rect x="20" y="34" width="160" height="72" rx="6" class="node-box node-blue" />
			<text x="100" y="62" text-anchor="middle" class="node-title">+ Add Vendor User</text>
			<text x="100" y="82" text-anchor="middle" class="node-sub">Bind VND_CODE + Role</text>

			<rect x="220" y="34" width="175" height="72" rx="6" class="node-box node-amber" />
			<text x="307" y="62" text-anchor="middle" class="node-title">Pending Activation</text>
			<text x="307" y="82" text-anchor="middle" class="node-sub">Status = 0 (72h Link)</text>

			<rect x="435" y="34" width="175" height="72" rx="6" class="node-box node-green" />
			<text x="522" y="62" text-anchor="middle" class="node-title">Active Account</text>
			<text x="522" y="82" text-anchor="middle" class="node-sub">Status = 1 (RBAC Ready)</text>

			<rect x="650" y="18" width="290" height="106" rx="6" class="node-box node-neutral" />
			<text x="795" y="42" text-anchor="middle" class="node-title">E-SCM Shared Scope &amp; Position</text>
			<text x="668" y="64" class="db-field">• Shared across grouped VENDORS_CODE</text>
			<text x="668" y="81" class="db-field">• Position: Sales / Production / QA</text>
			<text x="668" y="98" class="db-field">• Position: Logistics / Finance / Mgmt</text>
			<text x="668" y="115" class="db-field">• New accounts auto-start as PENDING</text>

			<!-- Bottom Audit / Inactivity Bar -->
			<rect x="220" y="142" width="390" height="54" rx="6" class="node-box node-red" />
			<text x="415" y="166" text-anchor="middle" class="node-title">Locked / Inactive (Status = 2)</text>
			<text x="415" y="184" text-anchor="middle" class="node-sub">Auto-flag if inactive &gt; 90 days or Admin suspends / Reset Password</text>

			<line x1="180" y1="70" x2="218" y2="70" class="svg-line" marker-end="url(#arrow-scm)" />
			<line x1="395" y1="70" x2="433" y2="70" class="svg-line" marker-end="url(#arrow-scm)" />
			<line x1="610" y1="70" x2="648" y2="70" class="svg-line" marker-end="url(#arrow-scm)" />
			<line x1="307" y1="106" x2="307" y2="140" class="svg-line" marker-end="url(#arrow-scm)" />
			<line x1="522" y1="106" x2="522" y2="140" class="svg-line" marker-end="url(#arrow-scm)" />
		</svg>
	</div>
</template>

<style scoped>
.vp-diagram-card {
	margin: 1rem 0 1.5rem;
	padding: 12px;
	border: 1px solid var(--vp-c-divider);
	background: var(--vp-c-bg-soft);
	overflow-x: auto;
}

.vp-diagram-svg {
	display: block;
	width: 100%;
	min-width: 720px;
	height: auto;
	font-family: var(--vp-font-family-base);
}

.lane-bg {
	fill: var(--vp-c-bg);
	stroke: var(--vp-c-divider);
	stroke-width: 1;
}

.lane-label,
.col-header {
	fill: var(--vp-c-text-2);
	font-size: 11px;
	font-weight: 700;
	letter-spacing: 0.05em;
}

.node-box {
	stroke-width: 1.5;
}

.node-neutral {
	fill: var(--vp-c-bg);
	stroke: var(--vp-c-divider);
}

.node-blue {
	fill: rgba(37, 99, 235, 0.08);
	stroke: #2563eb;
}

.node-amber {
	fill: rgba(217, 119, 6, 0.1);
	stroke: #d97706;
}

.node-green {
	fill: rgba(22, 163, 74, 0.1);
	stroke: #16a34a;
}

.node-red {
	fill: rgba(230, 0, 18, 0.08);
	stroke: #e60012;
}

.node-decision {
	fill: rgba(217, 119, 6, 0.12);
	stroke: #d97706;
	stroke-width: 1.5;
}

.node-title {
	fill: var(--vp-c-text-1);
	font-size: 13px;
	font-weight: 700;
}

.node-sub {
	fill: var(--vp-c-text-2);
	font-size: 11px;
}

.svg-line {
	stroke: var(--vp-c-text-3);
	stroke-width: 1.8;
}

.svg-arrow-fill {
	fill: var(--vp-c-text-3);
}

.edge-label-red {
	fill: #e60012;
	font-size: 11px;
	font-weight: 700;
}

.edge-label-green {
	fill: #16a34a;
	font-size: 11px;
	font-weight: 700;
}

.db-box {
	fill: var(--vp-c-bg);
	stroke: var(--vp-c-divider);
	stroke-width: 1.4;
}

.db-primary {
	stroke: #e60012;
}

.db-header-red {
	fill: #e60012;
}

.db-header-blue {
	fill: #1d4ed8;
}

.db-header-green {
	fill: #15803d;
}

.db-header-slate {
	fill: #334155;
}

.db-title {
	fill: #ffffff;
	font-size: 11px;
	font-weight: 700;
	letter-spacing: 0.02em;
}

.db-field {
	fill: var(--vp-c-text-1);
	font-size: 10.5px;
	font-family: var(--vp-font-family-mono);
}

.er-card {
	fill: #e60012;
	font-size: 10px;
	font-weight: 800;
}
</style>
