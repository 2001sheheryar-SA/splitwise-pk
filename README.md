# BASIC FLOW OF SPLITWISE APP
```text
[ User ] ───► Register 
                │
               
[ User ] ───► Login<br>
                │
[ User ] ───►  Can Create Groups<br>
                │
[ User ] ───► Can Update/delete/Show that Groups<br>
                │
[ User ] ───► Can Add/Remove members in that Groups<br>
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