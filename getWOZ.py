#!/usr/bin/env python
# coding: utf-8

# In[2]:


import pandas as pd


# In[3]:


def getWOZ(buurt_code):
    data = pd.read_csv('./dataset.csv')
    data = data.loc[
        (data['buurtcode'] == buurt_code)&
        (data['jaar'].iloc[0])
    ]
    return data.sort_values(by=['jaar'])


# In[4]:


data = getWOZ('BU00030000')
print data['woz'].iloc[-1]

