# 02 — Stop overpaying for AWS S3 (90-second hook)

## Meta

| | |
| --- | --- |
| **Length** | 90–120 seconds |
| **Audience** | SMB owners with growing cloud bills; ops directors |
| **Goal** | Convert AWS sticker shock into a free cloud audit booking |
| **Primary CTA** | Book a free cloud audit |

**Suggested title:** Stop overpaying for AWS S3 — cut storage costs 25–40% (no app rewrites)
**Suggested description (first 2 lines visible):**
> Most small businesses are overpaying on AWS S3 by 25 to 40 percent. The fix is simpler than you think — and you do not have to rewrite a single app. Free cloud audit: https://calendar.app.google/jSHYj7c6WtJGykGQ7

**Tags:** aws s3 cost, cloud cost optimization, s3 compatible storage, managed cloud services, smb cloud savings

---

## Cold open (0:00–0:07)

> *(Sharp, urgent.)*
> If you're paying AWS more than $500 a month for storage — there's a really good chance you're overpaying by 25 to 40 percent. Let me show you why.

**On screen:** big text — "**$500 → $300/mo** (no app changes)"

---

## Segment 1 — The trap (0:07–0:30)

> Here's the trap. AWS S3 is the default. It's where everyone starts. The APIs are documented, the SDKs are everywhere, and once your app is wired up — moving feels scary.
>
> So you stay. And every month the bill creeps up. Egress fees, request fees, the cold-storage tier you never finished migrating to. **It adds up. Fast.**

**B-roll:** screen-record an AWS billing dashboard (yours, scrubbed). Show the storage line item growing month over month.

---

## Segment 2 — The fix (0:30–0:60)

> Here's the thing. **S3 is a protocol, not just a product.** Backblaze, Wasabi, Cloudflare R2, even DigitalOcean Spaces — they all speak the S3 API. Same SDK calls, same bucket structure, same tooling.
>
> So for most workloads, you can migrate your buckets to a cheaper provider, point your apps at the new endpoint, and cut your storage bill by a third. **Zero rework on your app code.**
>
> That's a true story for the majority of clients we audit.

**On screen, two-column table:**
```
AWS S3             →  $0.023 / GB / month
S3-compatible      →  $0.005 – $0.006 / GB / month
+ no egress fees
```

---

## Segment 3 — What we do (0:60–1:20)

> At CSuite Code we run a free 30-minute cloud audit. We look at your current bill, identify the line items you're overspending on, and tell you straight up:
> - whether migrating actually saves you money for *your* workload,
> - what the cutover looks like, and
> - what it'd cost to do it for you — or to coach your team to do it themselves.
>
> No upsell. No three-year contract. Just the numbers.

**B-roll:** managed-cloud page (`csuitecode.com/managed-cloud/`) scrolling slowly. Stats bar in focus: "40% avg storage savings · 0 hours of downtime."

---

## Outro / CTA (1:20–1:30)

> Link's in the description. Bring your last AWS invoice — we'll go through it line by line.
>
> I'm Anthony. See you on the call.

---

## End-card overlay (5s hold)

```
Free cloud audit → calendar.app.google/jSHYj7c6WtJGykGQ7
csuitecode.com/managed-cloud/
```

Suggested "next video" thumbnail: **The 4-week AI workflow audit**.

---

## Recording notes

- The opening hook **has** to land hard. Re-take it 3–5 times.
- Have the AWS billing screenshot ready before you press record — do not
  fumble around looking for it on camera.
- If your real bill is too sensitive to show, use the AWS pricing calculator
  with a representative workload instead.
