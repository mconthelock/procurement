# 1. Overview of the Solution

To handle three distinct user groups (Management, Purchasing, and General Users) while managing P/R, P/O, Invoices, Products, and Vendors, we need a Role-Based Access Control (RBAC) architecture for our frontend.

Here is a breakdown of what each role's dashboard should conceptually contain:

- Manager / Management Team (Strategic View):
    - Focus: High-level metrics, financial oversight, and approvals.
    - Components: Total Spend (Current Month vs. Last Month), Top 5 Vendors by Spend, Pending High-Value Approvals (P/R or Invoices), and a Chart showing P/O vs. Invoiced amounts.
    - **Feature**
        - Spend vs. Budget Tracker: A visual gauge showing current departmental spend against the allocated quarterly budget.
        - Supplier Risk & Concentration: A pie chart highlighting if too much money is going to a single vendor, which is a supply chain risk.
        - 3-Way Matching Metrics: Highlighting invoices that successfully matched the Purchase Order (P/O) and the Goods Receipt.
        - Cost Savings KPI: Tracking negotiated savings (e.g., standard product price vs. actual P/O price).
- Purchasing Team (Operational View):
    - Focus: Actionable tasks and pipeline management.
    - Components: Pending P/Rs awaiting P/O creation, Active P/Os with delayed delivery statuses, Invoice discrepancies, and Vendor performance alerts.
- General Users (Personal View):
    - Focus: Tracking their own requests.
    - Components: Quick "Create P/R" action, Status tracker for their active P/Rs (Draft -> Submitted -> Approved -> P/O Created), and a history of their recent requests.
