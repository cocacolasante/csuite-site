# Tutorial 04 — Nonprofit cybersecurity essentials (the 5-point baseline)

## Meta

| | |
| --- | --- |
| **Length** | 7–9 minutes |
| **Audience** | Nonprofit EDs, operations directors, board treasurers — non-technical |
| **Goal** | Educate on the minimum security posture; convert worried EDs into IT assessments |
| **Primary CTA** | Free IT assessment |

**Suggested title:** Nonprofit cybersecurity — the 5 things every 501(c)(3) needs in place (plain English)
**Suggested description (first 2 lines visible):**
> Nonprofits hold donor data, payment info, sometimes health data — and most are protecting it with almost nothing. This is the minimum security baseline every 501(c)(3) needs in place. Free IT assessment: https://calendar.app.google/jSHYj7c6WtJGykGQ7

**Tags:** nonprofit cybersecurity, donor data security, 501c3 it security, nonprofit data breach, mfa nonprofit, nonprofit backup

---

## Cold open (0:00–0:20)

> *(Slightly serious tone.)*
> If your nonprofit holds donor names, addresses, payment information, or any kind of program data on real people — and almost every nonprofit does — you're a target.
>
> The good news: the baseline security every nonprofit needs is pretty short. Five things. They're not glamorous. They're not expensive. But if you don't have them, a single phishing email can take down your operations for a week.
>
> Let's go through the five.

**On screen:** big text — "**5 essentials. 7 minutes.**"

---

## Setting the stakes (0:20–1:00)

> Why does this matter? Two reasons.
>
> One — donors trust you. A breach of donor data is reputational damage you don't recover from quickly. Smaller donors quietly stop giving. Larger donors and corporate sponsors ask questions and find other recipients.
>
> Two — most state attorneys general now treat data breach reporting as a serious legal obligation. The fines are not enterprise-level. They're nonprofit-level — meaning they can hurt you.
>
> The baseline is genuinely simple. You can have all five of these in place inside of a month if you're starting from zero.

---

## Essential 1 — Multi-factor authentication, everywhere (1:00–2:15)

> **Number one. Multi-factor authentication. MFA. On every single staff account.**
>
> What it is: when someone logs in, they enter a password *and* a one-time code from their phone. The code changes every 30 seconds. Even if a hacker steals the password, they can't log in without the phone.
>
> Where it has to be on:
>
> - Email — Google Workspace or Microsoft 365.
> - Your donor CRM — Bloomerang, Salesforce, Little Green Light, whatever.
> - Your accounting software — QuickBooks, Sage, anything that touches money.
> - WordPress admin if you have one.
> - Bank accounts and payment processors.
>
> MFA is **free** on every platform I just named. It is also the single highest-impact security control you can deploy. It blocks 99 percent of credential-based attacks.
>
> If your staff resists because it's "annoying" — explain that the alternative is explaining a donor data breach to your board. They'll get over it.

**B-roll:** quick screen-record of enabling 2-step verification on a Google account.

---

## Essential 2 — Encrypted, off-site, tested backups (2:15–3:30)

> **Number two. Encrypted, off-site backups. Tested.**
>
> All three words matter.
>
> **Encrypted.** If someone gets ahold of your backup file, they shouldn't be able to read it. Most modern backup tools do this by default — but verify.
>
> **Off-site.** Your backup cannot live on the same server as the thing it's backing up. If ransomware hits the server, it encrypts your backup along with everything else. Off-site means cloud storage — separate provider, separate account, separate password.
>
> **Tested.** This is where nonprofits fail constantly. You're paying for a backup service every month. Have you ever actually restored from it? If the answer is no, you don't have backups — you have a billing line item.
>
> Do a restore drill every quarter. Pick a file. Pretend it's gone. Restore it from backup. Time it. If it doesn't work — fix it now, not during a real outage.
>
> Backup minimum for a nonprofit: donor CRM database, website, email mailboxes, financial records.

---

## Essential 3 — Up-to-date software, automatically (3:30–4:30)

> **Number three. Software updates. Automatic, wherever possible.**
>
> Most successful attacks don't use exotic exploits. They use vulnerabilities that were patched 18 months ago — but the target never installed the patch.
>
> The list to keep updated:
>
> - Operating systems on staff laptops — Windows or macOS updates, monthly minimum.
> - Browsers — Chrome, Edge, Firefox, Safari.
> - WordPress core, plugins, themes — *especially* plugins. Outdated plugins are the number-one way nonprofit sites get hacked.
> - SaaS tools — most update themselves. Just don't disable the auto-update.
>
> Set everything to auto-update where you reasonably can. Where you can't — like a WordPress plugin you've customized — put a calendar reminder for the first Monday of every month to check it manually.

**B-roll:** screen-record the WordPress plugins screen with multiple "update available" prompts highlighted.

---

## Essential 4 — A one-page incident response plan (4:30–5:30)

> **Number four. A one-page incident response plan.**
>
> Not a 40-page binder. A single page that answers four questions:
>
> 1. **Who do we call first** if a laptop is stolen, a phishing attempt succeeds, or the donor database goes offline?
> 2. **What do we shut off** to contain the damage?
> 3. **Who do we have to tell** — board, donors, attorney general, payment processor — and on what timeline?
> 4. **Who in our org has authority** to make the "we should report this" call?
>
> Print this. Put it on the wall in the office. Email it to everyone on staff and to your board chair.
>
> The reason: in a real incident, no one reads the manual. They read the wall.
>
> If you've never written one of these — and most nonprofits haven't — a security consultant or your MSP can draft it in about an hour.

---

## Essential 5 — Annual staff training, even a short one (5:30–6:30)

> **Number five. Annual staff security training.**
>
> Doesn't have to be elaborate. A 30-minute video that covers three things:
>
> - **Phishing recognition.** What a fake "your password expired" email looks like. The general rule: real organizations don't email you a link that says "click here to verify your password."
> - **Password hygiene.** A password manager — like 1Password or Bitwarden — and one strong password per account. No reusing.
> - **Donor data handling.** Where it lives, who has access, what to do if you accidentally email donor info to the wrong person.
>
> Most attacks on nonprofits start with one person clicking one bad link. Thirty minutes of training, once a year, cuts that risk substantially.

**B-roll:** generic stock footage of a phishing email warning, or a screenshot of a real (anonymized) phishing attempt.

---

## What this all costs (6:30–7:15)

> Quick reality check on cost.
>
> - MFA — **free** on every platform.
> - Encrypted backups — **$10 to $50 per month** for a small nonprofit on a managed backup service.
> - Software updates — **time only**, mostly automated.
> - Incident response plan — **one-time $200 to $1,000** consulting fee, or DIY if you're willing to write it.
> - Annual training — **$5 to $20 per staff member per year** with services like KnowBe4, or free with a curated YouTube playlist and a 30-minute meeting.
>
> Total annual cost for a 10-person nonprofit: somewhere between **$300 and $1,500 a year**. The cost of *not* doing it: incalculably worse.

---

## Outro / CTA (7:15–8:00)

> If you're not sure where your nonprofit stands on any of these five — that's exactly what a free IT assessment covers. We go through your stack, identify what's missing, and give you a one-page action plan. No commitment. Link's in the description.
>
> And if you want the long-form written version — the complete nonprofit IT guide on the site covers all of this and more. Also linked below.
>
> Like, subscribe, share this with a board member who needs to see it. I'll see you in the next one.

---

## End-card overlay (5s hold)

```
Free IT assessment → calendar.app.google/jSHYj7c6WtJGykGQ7
Full guide → csuitecode.com/nonprofit-it-support-guide/
csuitecode.com/nonprofit-it-support/
```

Suggested "next video" thumbnail: **How to choose nonprofit IT support**.

---

## Recording notes

- Tone is serious-but-not-fearmongering. You're the trusted advisor, not the
  alarmist vendor.
- For the cost section, the numbers move every couple years — re-check
  pricing on Backblaze, KnowBe4, and managed backup providers before
  recording.
- This video pairs perfectly with Tutorial 01 (choosing IT support). Cross-
  link them in the end cards and pinned comments.
