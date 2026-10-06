# BASIC FLOW OF SPLITWISE APP
[ User ] ───► Register
                │
[ User ] ───► Login
                │
[ User ] ───►  Can Create Groups
                │
[ User ] ───► Can Update/delete/Show that Groups
                │
[ User ] ───► Can Add/Remove members in that Groups
                │
[ Group Member ] ───► Creates Expense (Equal / Exact / Percentage)
                              │
                              ├──► Updates Group Balance Ledger
                              │
[ Group Member ] ───► Update/Delete/Show that Expense
                              │
                              │                           
[ Group Member ] ───► Creates Settlement
                              │
                              ├──► Validates Settlement Amount 
                              │    (Amount <= Outstanding Balance + Original Settlement)
                              │
                              └──► Recalculates & Updates Ledger Balance
                              │
[ Group Member ] ───►  Update/Delete/Show that Settlement